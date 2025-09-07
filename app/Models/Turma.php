<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'serie_id', 'turno_id', 'professor_regente_id', 'ano_letivo', 
        'capacidade_maxima', 'sala', 'active', 'observacoes'
    ];

    protected $casts = [
        'active' => 'boolean',
        'capacidade_maxima' => 'integer'
    ];

    /**
     * Get the serie (grade level) for this turma
     */
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    /**
     * Get the turno (shift) for this turma
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    /**
     * Get the professor regente (homeroom teacher) for this turma
     */
    public function professor_regente()
    {
        return $this->belongsTo(User::class, 'professor_regente_id');
    }

    /**
     * Get student records for this turma
     */
    public function student_records()
    {
        return $this->hasMany(StudentRecord::class);
    }

    /**
     * Get active students in this turma
     */
    public function students()
    {
        return $this->student_records()
                    ->where('grad', false)
                    ->where('wd', false)
                    ->with('user');
    }

    /**
     * Scope for active turmas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope for current academic year
     */
    public function scopeCurrentYear($query)
    {
        return $query->where('ano_letivo', date('Y'));
    }

    /**
     * Scope for specific academic year
     */
    public function scopeYear($query, $year)
    {
        return $query->where('ano_letivo', $year);
    }

    /**
     * Get the full display name
     */
    public function getFullNameAttribute()
    {
        $parts = [];
        
        if ($this->serie) {
            $parts[] = $this->serie->name;
        }
        
        $parts[] = $this->name;
        
        if ($this->turno) {
            $parts[] = $this->turno->name;
        }
        
        return implode(' - ', $parts);
    }

    /**
     * Get current enrollment count
     */
    public function getCurrentEnrollmentAttribute()
    {
        return $this->students()->count();
    }

    /**
     * Get available spots
     */
    public function getAvailableSpotsAttribute()
    {
        if (!$this->capacidade_maxima) {
            return null;
        }
        
        return $this->capacidade_maxima - $this->getCurrentEnrollmentAttribute();
    }

    /**
     * Check if turma is full
     */
    public function isFull()
    {
        if (!$this->capacidade_maxima) {
            return false;
        }
        
        return $this->getCurrentEnrollmentAttribute() >= $this->capacidade_maxima;
    }

    /**
     * Check if turma has available spots
     */
    public function hasAvailableSpots()
    {
        return !$this->isFull();
    }

    /**
     * Get turma info for display
     */
    public function getInfoDisplayAttribute()
    {
        $info = [];
        
        if ($this->sala) {
            $info[] = 'Sala: ' . $this->sala;
        }
        
        if ($this->capacidade_maxima) {
            $info[] = 'Vagas: ' . $this->getCurrentEnrollmentAttribute() . '/' . $this->capacidade_maxima;
        }
        
        if ($this->professor_regente) {
            $info[] = 'Prof.: ' . $this->professor_regente->name;
        }
        
        return implode(' | ', $info);
    }
}