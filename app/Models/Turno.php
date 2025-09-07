<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'codigo', 'inicio', 'fim', 'active', 'description'
    ];

    protected $casts = [
        'active' => 'boolean',
        'inicio' => 'datetime:H:i',
        'fim' => 'datetime:H:i'
    ];

    /**
     * Get turmas for this turno
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Get student records for this turno
     */
    public function student_records()
    {
        return $this->hasMany(StudentRecord::class);
    }

    /**
     * Scope for active turnos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Get the formatted time range
     */
    public function getHorarioAttribute()
    {
        if ($this->inicio && $this->fim) {
            return $this->inicio->format('H:i') . ' às ' . $this->fim->format('H:i');
        }
        return '';
    }

    /**
     * Get the full display name with time
     */
    public function getFullNameAttribute()
    {
        $horario = $this->getHorarioAttribute();
        return $this->name . ($horario ? ' (' . $horario . ')' : '');
    }

    /**
     * Check if this is morning shift
     */
    public function isManha()
    {
        return $this->codigo === 'M' || strtolower($this->name) === 'manhã';
    }

    /**
     * Check if this is afternoon shift
     */
    public function isTarde()
    {
        return $this->codigo === 'T' || strtolower($this->name) === 'tarde';
    }

    /**
     * Check if this is evening shift
     */
    public function isNoite()
    {
        return $this->codigo === 'N' || strtolower($this->name) === 'noite';
    }

    /**
     * Check if this is full-time
     */
    public function isIntegral()
    {
        return $this->codigo === 'I' || strtolower($this->name) === 'integral';
    }
}