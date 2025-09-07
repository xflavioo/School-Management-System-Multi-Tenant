<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nivel_ensino', 'order', 'active', 'description'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get turmas for this serie
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Get student records for this serie
     */
    public function student_records()
    {
        return $this->hasMany(StudentRecord::class);
    }

    /**
     * Scope for elementary school (Ensino Fundamental)
     */
    public function scopeFundamental($query)
    {
        return $query->where('nivel_ensino', 'fundamental');
    }

    /**
     * Scope for high school (Ensino Médio)
     */
    public function scopeMedio($query)
    {
        return $query->where('nivel_ensino', 'medio');
    }

    /**
     * Scope for active series
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Get the full display name with education level
     */
    public function getFullNameAttribute()
    {
        $level = $this->nivel_ensino === 'fundamental' ? 'EF' : 'EM';
        return $this->name . ' (' . $level . ')';
    }

    /**
     * Check if this is elementary school
     */
    public function isFundamental()
    {
        return $this->nivel_ensino === 'fundamental';
    }

    /**
     * Check if this is high school
     */
    public function isMedio()
    {
        return $this->nivel_ensino === 'medio';
    }
}