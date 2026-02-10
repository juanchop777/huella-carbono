<?php

namespace Modules\HUELLACARBONO\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class DailyConsumption extends Model
{
    use HasFactory;

    protected $table = 'hc_daily_consumptions';

    protected $fillable = [
        'productive_unit_id',
        'emission_factor_id',
        'registered_by',
        'consumption_date',
        'quantity',
        'nitrogen_percentage',
        'co2_generated',
        'observations'
    ];

    protected $casts = [
        'consumption_date' => 'date',
        'quantity' => 'decimal:3',
        'nitrogen_percentage' => 'decimal:2',
        'co2_generated' => 'decimal:3',
    ];

    /**
     * Relación con la unidad productiva
     */
    public function productiveUnit()
    {
        return $this->belongsTo(ProductiveUnit::class, 'productive_unit_id');
    }

    /**
     * Relación con el factor de emisión
     */
    public function emissionFactor()
    {
        return $this->belongsTo(EmissionFactor::class, 'emission_factor_id');
    }

    /**
     * Relación con el usuario que registró
     */
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    /**
     * Indica si el registro fue agregado como retraso (aprobado por Admin en fecha distinta al consumo diario)
     */
    public function isDelayFromAdminApproval(): bool
    {
        $obs = $this->observations ?? '';
        return str_contains($obs, 'Registro aprobado por Admin') || str_contains($obs, 'solicitud #');
    }

    /**
     * Calcular automáticamente el CO2 al guardar
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($consumption) {
            $factor = EmissionFactor::find($consumption->emission_factor_id);
            if ($factor) {
                $consumption->co2_generated = $factor->calculateCO2(
                    $consumption->quantity,
                    $consumption->nitrogen_percentage
                );
            }
        });
    }
}





