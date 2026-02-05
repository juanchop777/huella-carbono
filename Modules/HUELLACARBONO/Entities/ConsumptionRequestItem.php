<?php

namespace Modules\HUELLACARBONO\Entities;

use Illuminate\Database\Eloquent\Model;

class ConsumptionRequestItem extends Model
{
    protected $table = 'hc_consumption_request_items';

    protected $fillable = [
        'consumption_request_id',
        'emission_factor_id',
        'quantity',
        'nitrogen_percentage'
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'nitrogen_percentage' => 'decimal:2',
    ];

    public function consumptionRequest()
    {
        return $this->belongsTo(ConsumptionRequest::class, 'consumption_request_id');
    }

    public function emissionFactor()
    {
        return $this->belongsTo(EmissionFactor::class, 'emission_factor_id');
    }
}
