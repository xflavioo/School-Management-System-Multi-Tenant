<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Feriado extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendario_id', 'nome', 'data', 'tipo', 'recorrente', 'observacoes'
    ];

    protected $casts = [
        'data' => 'date',
        'recorrente' => 'boolean'
    ];

    /**
     * Get the calendario letivo for this feriado
     */
    public function calendario()
    {
        return $this->belongsTo(CalendarioLetivo::class, 'calendario_id');
    }

    /**
     * Scope for national holidays
     */
    public function scopeNacional($query)
    {
        return $query->where('tipo', 'nacional');
    }

    /**
     * Scope for state holidays
     */
    public function scopeEstadual($query)
    {
        return $query->where('tipo', 'estadual');
    }

    /**
     * Scope for municipal holidays
     */
    public function scopeMunicipal($query)
    {
        return $query->where('tipo', 'municipal');
    }

    /**
     * Scope for school holidays
     */
    public function scopeEscolar($query)
    {
        return $query->where('tipo', 'escolar');
    }

    /**
     * Scope for recurring holidays
     */
    public function scopeRecorrente($query)
    {
        return $query->where('recorrente', true);
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
     * Check if holiday falls on weekend
     */
    public function isFinalSemana()
    {
        return Carbon::parse($this->data)->isWeekend();
    }

    /**
     * Get holiday type in Portuguese
     */
    public function getTipoDescricaoAttribute()
    {
        $tipos = [
            'nacional' => 'Feriado Nacional',
            'estadual' => 'Feriado Estadual',
            'municipal' => 'Feriado Municipal',
            'escolar' => 'Feriado Escolar'
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }

    /**
     * Generate next year occurrence for recurring holidays
     */
    public function generateNextYear($newYear)
    {
        if (!$this->recorrente) {
            return null;
        }

        $currentDate = Carbon::parse($this->data);
        $newDate = $currentDate->copy()->year($newYear);

        return [
            'nome' => $this->nome,
            'data' => $newDate->format('Y-m-d'),
            'tipo' => $this->tipo,
            'recorrente' => true,
            'observacoes' => $this->observacoes
        ];
    }
}