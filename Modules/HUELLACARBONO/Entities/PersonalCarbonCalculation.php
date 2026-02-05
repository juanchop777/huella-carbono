<?php

namespace Modules\HUELLACARBONO\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalCarbonCalculation extends Model
{
    use HasFactory;

    protected $table = 'hc_personal_carbon_calculations';

    protected $fillable = [
        'name',
        'email',
        'water_consumption',
        'energy_consumption',
        'gasoline_consumption',
        'diesel_consumption',
        'waste_generation',
        'number_of_animals',
        'synthetic_fertilizers',
        'fertilizer_nitrogen_percentage',
        'insecticides',
        'fungicides',
        'herbicides',
        'total_co2',
        'period'
    ];

    protected $casts = [
        'water_consumption' => 'decimal:3',
        'energy_consumption' => 'decimal:3',
        'gasoline_consumption' => 'decimal:3',
        'diesel_consumption' => 'decimal:3',
        'waste_generation' => 'decimal:3',
        'number_of_animals' => 'integer',
        'synthetic_fertilizers' => 'decimal:3',
        'fertilizer_nitrogen_percentage' => 'decimal:2',
        'insecticides' => 'decimal:3',
        'fungicides' => 'decimal:3',
        'herbicides' => 'decimal:3',
        'total_co2' => 'decimal:3',
    ];

    /**
     * Calcular el total de CO2
     */
    public static function calculateTotalCO2($data)
    {
        $factors = [
            'water_consumption' => 0.0001427,
            'energy_consumption' => 0.112,
            'gasoline_consumption' => 8.8,
            'diesel_consumption' => 10.16,
            'waste_generation' => 0.003,
            'number_of_animals' => 3.36,
            'insecticides' => 5.1,
            'fungicides' => 3.9,
            'herbicides' => 6.3,
        ];

        $total = 0;

        foreach ($factors as $key => $factor) {
            if (isset($data[$key])) {
                $total += $data[$key] * $factor;
            }
        }

        // Fertilizantes con porcentaje de nitrógeno
        if (isset($data['synthetic_fertilizers']) && isset($data['fertilizer_nitrogen_percentage'])) {
            $total += $data['synthetic_fertilizers'] * 0.00265 * ($data['fertilizer_nitrogen_percentage'] / 100);
        }

        return round($total, 3);
    }
}





