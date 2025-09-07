<?php

namespace App\Services;

use App\Models\Serie;
use App\Models\Turma;
use App\Models\Turno;
use App\Models\StudentRecord;
use App\User;
use Illuminate\Support\Facades\DB;

class BrazilianEnrollmentService
{
    /**
     * Enroll a student in a turma
     *
     * @param User $student
     * @param int $turmaId
     * @param string $session
     * @param array $additionalData
     * @return StudentRecord
     * @throws \Exception
     */
    public function enrollStudent(User $student, int $turmaId, string $session, array $additionalData = [])
    {
        return DB::transaction(function () use ($student, $turmaId, $session, $additionalData) {
            $turma = Turma::with(['serie', 'turno'])->findOrFail($turmaId);
            
            // Check if turma has available spots
            if ($turma->isFull()) {
                throw new \Exception('A turma está lotada. Não há vagas disponíveis.');
            }
            
            // Check if student is already enrolled in this session
            $existingRecord = StudentRecord::where('user_id', $student->id)
                                         ->where('session', $session)
                                         ->where('grad', false)
                                         ->where('wd', false)
                                         ->first();
            
            if ($existingRecord) {
                throw new \Exception('O aluno já está matriculado no ano letivo ' . $session . '.');
            }
            
            // Generate admission number if not provided
            $admNo = $additionalData['adm_no'] ?? $this->generateAdmissionNumber($turma, $session);
            
            // Create student record
            $studentRecord = StudentRecord::create([
                'user_id' => $student->id,
                'serie_id' => $turma->serie_id,
                'turno_id' => $turma->turno_id,
                'turma_id' => $turma->id,
                'my_class_id' => $additionalData['my_class_id'] ?? null, // For compatibility
                'section_id' => $additionalData['section_id'] ?? null, // For compatibility
                'session' => $session,
                'adm_no' => $admNo,
                'year_admitted' => date('Y'),
                'my_parent_id' => $additionalData['my_parent_id'] ?? null,
                'age' => $this->calculateAge($student->dob),
                // Brazilian specific fields
                'enrollment_type' => $additionalData['enrollment_type'] ?? 'regular',
                'transport_type' => $additionalData['transport_type'] ?? null,
                'has_special_needs' => $additionalData['has_special_needs'] ?? false,
                'special_needs_description' => $additionalData['special_needs_description'] ?? null,
                'emergency_contact_name' => $additionalData['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $additionalData['emergency_contact_phone'] ?? null,
                'emergency_contact_relationship' => $additionalData['emergency_contact_relationship'] ?? null,
                'has_scholarship' => $additionalData['has_scholarship'] ?? false,
                'scholarship_percentage' => $additionalData['scholarship_percentage'] ?? null,
                'scholarship_type' => $additionalData['scholarship_type'] ?? null,
            ]);
            
            return $studentRecord;
        });
    }

    /**
     * Transfer student to another turma
     *
     * @param StudentRecord $studentRecord
     * @param int $newTurmaId
     * @return StudentRecord
     * @throws \Exception
     */
    public function transferStudent(StudentRecord $studentRecord, int $newTurmaId)
    {
        return DB::transaction(function () use ($studentRecord, $newTurmaId) {
            $newTurma = Turma::with(['serie', 'turno'])->findOrFail($newTurmaId);
            
            // Check if new turma has available spots
            if ($newTurma->isFull()) {
                throw new \Exception('A turma de destino está lotada.');
            }
            
            // Update student record
            $studentRecord->update([
                'serie_id' => $newTurma->serie_id,
                'turno_id' => $newTurma->turno_id,
                'turma_id' => $newTurma->id,
            ]);
            
            return $studentRecord->fresh();
        });
    }

    /**
     * Promote students to next grade level
     *
     * @param array $studentIds
     * @param int $newSerieId
     * @param string $newSession
     * @return array
     */
    public function promoteStudents(array $studentIds, int $newSerieId, string $newSession)
    {
        $results = [];
        
        DB::transaction(function () use ($studentIds, $newSerieId, $newSession, &$results) {
            foreach ($studentIds as $studentId) {
                try {
                    $currentRecord = StudentRecord::where('user_id', $studentId)
                                                 ->where('grad', false)
                                                 ->where('wd', false)
                                                 ->latest()
                                                 ->first();
                    
                    if (!$currentRecord) {
                        $results[$studentId] = ['success' => false, 'message' => 'Registro do aluno não encontrado'];
                        continue;
                    }
                    
                    // Mark current record as graduated
                    $currentRecord->update(['grad' => true, 'grad_date' => now()]);
                    
                    // Create new record for next grade
                    $newRecord = StudentRecord::create([
                        'user_id' => $currentRecord->user_id,
                        'serie_id' => $newSerieId,
                        'session' => $newSession,
                        'my_parent_id' => $currentRecord->my_parent_id,
                        'adm_no' => $currentRecord->adm_no, // Keep same admission number
                        'year_admitted' => $currentRecord->year_admitted,
                        'age' => $this->calculateAge($currentRecord->user->dob),
                        // Copy other relevant fields
                        'enrollment_type' => $currentRecord->enrollment_type,
                        'transport_type' => $currentRecord->transport_type,
                        'has_special_needs' => $currentRecord->has_special_needs,
                        'special_needs_description' => $currentRecord->special_needs_description,
                        'emergency_contact_name' => $currentRecord->emergency_contact_name,
                        'emergency_contact_phone' => $currentRecord->emergency_contact_phone,
                        'emergency_contact_relationship' => $currentRecord->emergency_contact_relationship,
                        'has_scholarship' => $currentRecord->has_scholarship,
                        'scholarship_percentage' => $currentRecord->scholarship_percentage,
                        'scholarship_type' => $currentRecord->scholarship_type,
                    ]);
                    
                    $results[$studentId] = ['success' => true, 'record' => $newRecord];
                    
                } catch (\Exception $e) {
                    $results[$studentId] = ['success' => false, 'message' => $e->getMessage()];
                }
            }
        });
        
        return $results;
    }

    /**
     * Generate admission number
     *
     * @param Turma $turma
     * @param string $session
     * @return string
     */
    private function generateAdmissionNumber(Turma $turma, string $session)
    {
        $year = substr($session, 0, 4);
        $serieCode = str_pad($turma->serie->order, 2, '0', STR_PAD_LEFT);
        $turnoCode = $turma->turno->codigo;
        
        // Get next sequential number for this turma/session
        $lastNumber = StudentRecord::where('session', $session)
                                  ->where('turma_id', $turma->id)
                                  ->count() + 1;
        
        $sequentialNumber = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
        
        return $year . $serieCode . $turnoCode . $sequentialNumber;
    }

    /**
     * Calculate age from date of birth
     *
     * @param string|null $dob
     * @return int|null
     */
    private function calculateAge($dob)
    {
        if (!$dob) {
            return null;
        }
        
        return \Carbon\Carbon::parse($dob)->age;
    }

    /**
     * Get available turmas for enrollment
     *
     * @param int $serieId
     * @param string $session
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableTurmas(int $serieId, string $session)
    {
        return Turma::with(['turno', 'professor_regente'])
                   ->where('serie_id', $serieId)
                   ->where('ano_letivo', substr($session, 0, 4))
                   ->where('active', true)
                   ->get()
                   ->filter(function ($turma) {
                       return $turma->hasAvailableSpots();
                   });
    }
}