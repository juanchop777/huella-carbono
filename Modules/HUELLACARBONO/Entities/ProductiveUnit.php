<?php

namespace Modules\HUELLACARBONO\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class ProductiveUnit extends Model
{
    use HasFactory;

    protected $table = 'hc_productive_units';

    protected $fillable = [
        'name',
        'code',
        'description',
        'latitude',
        'longitude',
        'productive_unit_id', // Relación con unidad original de SICA
        'leader_user_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Relación con la unidad productiva original de SICA (opcional)
     */
    public function originalUnit()
    {
        return $this->belongsTo(\Modules\SICA\Entities\ProductiveUnit::class, 'productive_unit_id');
    }

    /**
     * Relación con el líder de la unidad
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_user_id');
    }

    /**
     * Relación con los consumos diarios
     */
    public function dailyConsumptions()
    {
        return $this->hasMany(DailyConsumption::class, 'productive_unit_id');
    }

    /**
     * Obtener consumos de un rango de fechas
     */
    public function getConsumptionsByDateRange($startDate, $endDate)
    {
        return $this->dailyConsumptions()
            ->whereBetween('consumption_date', [$startDate, $endDate])
            ->with('emissionFactor')
            ->get();
    }

    /**
     * Calcular huella de carbono total de un período
     */
    public function calculateCarbonFootprint($startDate, $endDate)
    {
        return $this->dailyConsumptions()
            ->whereBetween('consumption_date', [$startDate, $endDate])
            ->sum('co2_generated');
    }
}

