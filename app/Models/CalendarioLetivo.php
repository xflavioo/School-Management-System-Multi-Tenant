<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalendarioLetivo extends Model
{
    use HasFactory;

    protected $table = 'calendarios_letivos';

    protected $fillable = [
        'ano', 'inicio', 'fim', 'dias_letivos_minimos', 'active', 'observacoes'
    ];

    protected $casts = [
        'active' => 'boolean',
        'inicio' => 'date',
        'fim' => 'date',
        'dias_letivos_minimos' => 'integer'
    ];

    /**
     * Get dias letivos for this calendar
     */
    public function diasLetivos()
    {
        return $this->hasMany(DiaLetivo::class, 'calendario_id');
    }

    /**
     * Get feriados for this calendar
     */
    public function feriados()
    {
        return $this->hasMany(Feriado::class, 'calendario_id');
    }

    /**
     * Get active calendar
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Get calendar for specific year
     */
    public function scopeYear($query, $year)
    {
        return $query->where('ano', $year);
    }

    /**
     * Calculate total school days excluding weekends and holidays
     */
    public function calculateDiasLetivos()
    {
        $inicio = Carbon::parse($this->inicio);
        $fim = Carbon::parse($this->fim);
        
        $feriados = $this->feriados()->pluck('data')->map(function ($data) {
            return Carbon::parse($data)->format('Y-m-d');
        })->toArray();
        
        $diasLetivos = 0;
        $currentDate = $inicio->copy();
        
        while ($currentDate->lte($fim)) {
            // Skip weekends (Saturday and Sunday)
            if (!$currentDate->isWeekend()) {
                // Skip holidays
                if (!in_array($currentDate->format('Y-m-d'), $feriados)) {
                    $diasLetivos++;
                }
            }
            $currentDate->addDay();
        }
        
        return $diasLetivos;
    }

    /**
     * Check if calendar meets minimum required school days (200)
     */
    public function meetsMinimumDays()
    {
        return $this->calculateDiasLetivos() >= ($this->dias_letivos_minimos ?: 200);
    }

    /**
     * Get formatted academic year period
     */
    public function getPeriodoAttribute()
    {
        return Carbon::parse($this->inicio)->format('d/m/Y') . ' a ' . 
               Carbon::parse($this->fim)->format('d/m/Y');
    }

    /**
     * Get current week of academic year
     */
    public function getCurrentWeek()
    {
        $today = Carbon::today();
        $inicio = Carbon::parse($this->inicio);
        
        if ($today->lt($inicio)) {
            return 0; // Not started yet
        }
        
        return $inicio->diffInWeeks($today) + 1;
    }

    /**
     * Check if a date is a school day
     */
    public function isSchoolDay(Carbon $date)
    {
        // Check if date is within academic year
        if ($date->lt($this->inicio) || $date->gt($this->fim)) {
            return false;
        }
        
        // Check if it's a weekend
        if ($date->isWeekend()) {
            return false;
        }
        
        // Check if it's a holiday
        $isHoliday = $this->feriados()
                         ->where('data', $date->format('Y-m-d'))
                         ->exists();
        
        return !$isHoliday;
    }

    /**
     * Get remaining school days in academic year
     */
    public function getRemainingSchoolDays()
    {
        $today = Carbon::today();
        $fim = Carbon::parse($this->fim);
        
        if ($today->gt($fim)) {
            return 0;
        }
        
        $feriados = $this->feriados()
                        ->where('data', '>=', $today->format('Y-m-d'))
                        ->where('data', '<=', $fim->format('Y-m-d'))
                        ->pluck('data')
                        ->map(function ($data) {
                            return Carbon::parse($data)->format('Y-m-d');
                        })->toArray();
        
        $remainingDays = 0;
        $currentDate = $today->copy();
        
        while ($currentDate->lte($fim)) {
            if (!$currentDate->isWeekend() && !in_array($currentDate->format('Y-m-d'), $feriados)) {
                $remainingDays++;
            }
            $currentDate->addDay();
        }
        
        return $remainingDays;
    }
}