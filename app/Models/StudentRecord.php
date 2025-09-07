<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRecord extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        'session', 'user_id', 'my_class_id', 'section_id', 'my_parent_id', 'dorm_id', 'dorm_room_no', 'adm_no', 'year_admitted', 'wd', 'wd_date', 'grad', 'grad_date', 'house', 'age',
        'enrollment_type', 'transport_type', 'has_special_needs', 'special_needs_description',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
        'has_birth_certificate', 'has_vaccination_card', 'has_medical_certificate', 'has_transfer_certificate',
        'previous_school', 'previous_school_city', 'previous_school_state',
        'has_scholarship', 'scholarship_percentage', 'scholarship_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function my_parent()
    {
        return $this->belongsTo(User::class);
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    /**
     * Get student's enrollment status
     */
    public function getSituacaoMatriculaAttribute()
    {
        if ($this->grad) {
            return 'Formado';
        }
        
        if ($this->wd) {
            return 'Transferido';
        }
        
        return 'Matriculado';
    }

    /**
     * Check if student has all required documents
     */
    public function hasAllRequiredDocuments()
    {
        return $this->has_birth_certificate && 
               $this->has_vaccination_card && 
               $this->has_medical_certificate;
    }

    /**
     * Get missing documents list
     */
    public function getMissingDocuments()
    {
        $missing = [];
        
        if (!$this->has_birth_certificate) {
            $missing[] = 'Certidão de Nascimento';
        }
        
        if (!$this->has_vaccination_card) {
            $missing[] = 'Cartão de Vacinação';
        }
        
        if (!$this->has_medical_certificate) {
            $missing[] = 'Atestado Médico';
        }
        
        if (!$this->has_transfer_certificate && $this->previous_school) {
            $missing[] = 'Declaração de Transferência';
        }
        
        return $missing;
    }

    /**
     * Get scholarship information formatted
     */
    public function getBolsaFormatadaAttribute()
    {
        if (!$this->has_scholarship) {
            return 'Não possui bolsa';
        }
        
        $percentage = $this->scholarship_percentage ?: 0;
        $type = $this->scholarship_type ?: 'Bolsa';
        
        return $type . ' - ' . number_format($percentage, 0) . '%';
    }
}
