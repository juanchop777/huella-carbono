<?php

namespace Modules\HUELLACARBONO\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmissionFactor extends Model
{
    use HasFactory;

    protected $table = 'hc_emission_factors';

    protected $fillable = [
        'name',
        'code',
        'unit',
        'factor',
        'description',
        'requires_percentage',
        'is_active',
        'order'
    ];

    protected $casts = [
        'factor' => 'decimal:7',
        'requires_percentage' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relación con los consumos diarios
     */
    public function dailyConsumptions()
    {
        return $this->hasMany(DailyConsumption::class, 'emission_factor_id');
    }

    /**
     * Calcular CO2 generado
     */
    public function calculateCO2($quantity, $nitrogenPercentage = null)
    {
        if ($this->requires_percentage && $nitrogenPercentage !== null) {
            return $quantity * $this->factor * ($nitrogenPercentage / 100);
        }
        return $quantity * $this->factor;
    }

    /**
     * Scope para factores activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}

