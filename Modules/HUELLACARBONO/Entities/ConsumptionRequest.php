<?php

namespace Modules\HUELLACARBONO\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ConsumptionRequest extends Model
{
    protected $table = 'hc_consumption_requests';

    protected $fillable = [
        'productive_unit_id',
        'requested_by',
        'consumption_date',
        'status',
        'reviewed_by',
        'reviewed_at',
        'observations'
    ];

    protected $casts = [
        'consumption_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function productiveUnit()
    {
        return $this->belongsTo(ProductiveUnit::class, 'productive_unit_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function items()
    {
        return $this->hasMany(ConsumptionRequestItem::class, 'consumption_request_id');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}
