<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiaLetivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendario_id', 'data', 'tipo_dia', 'observacoes'
    ];

    protected $casts = [
        'data' => 'date'
    ];

    /**
     * Get the calendario letivo for this dia letivo
     */
    public function calendario()
    {
        return $this->belongsTo(CalendarioLetivo::class, 'calendario_id');
    }

    /**
     * Scope for normal school days
     */
    public function scopeNormal($query)
    {
        return $query->where('tipo_dia', 'normal');
    }

    /**
     * Scope for special school days (activities, events, etc.)
     */
    public function scopeEspecial($query)
    {
        return $query->where('tipo_dia', 'especial');
    }

    /**
     * Scope for suspended school days
     */
    public function scopeSuspenso($query)
    {
        return $query->where('tipo_dia', 'suspenso');
    }

    /**
     * Get formatted date
     */
    public function getDataFormatadaAttribute()
    {
        return Carbon::parse($this->data)->format('d/m/Y');
    }

    /**
     * Get day of week in Portuguese
     */
    public function getDiaSemanaAttribute()
    {
        $diasSemana = [
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado'
        ];

        $dayName = Carbon::parse($this->data)->format('l');
        return $diasSemana[$dayName] ?? $dayName;
    }

    /**
     * Get day type description
     */
    public function getTipoDescricaoAttribute()
    {
        $tipos = [
            'normal' => 'Dia Letivo Normal',
            'especial' => 'Dia Letivo Especial',
            'suspenso' => 'Dia Letivo Suspenso',
            'reposicao' => 'Reposição de Aula'
        ];

        return $tipos[$this->tipo_dia] ?? $this->tipo_dia;
    }

    /**
     * Check if this is a weekend day (unusual for school days)
     */
    public function isWeekend()
    {
        return Carbon::parse($this->data)->isWeekend();
    }

    /**
     * Check if this day counts towards minimum school days
     */
    public function countsAsSchoolDay()
    {
        return in_array($this->tipo_dia, ['normal', 'especial', 'reposicao']);
    }
}