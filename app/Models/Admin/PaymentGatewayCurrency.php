<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayCurrency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $callable_data;

    protected $appends = [];

    protected $casts = [
        'id'                    => 'integer',
        'payment_gateway_id'    => 'integer',
        'min_limit'             => 'decimal:8',
        'max_limit'             => 'decimal:8',
        'percent_charge'        => 'decimal:8',
        'fixed_charge'          => 'decimal:8',
        'rate'                  => 'decimal:8',
        'image'                 => 'string',
        'currency_symbol'       => 'string',
    ];

    /**
     * Get a subset of the model's attributes.
     *
     * @param  array|mixed  $attributes
     * @return array
     */
    public function getOnly($attributes)
    {
        $this->callable_data = $this->only($attributes);
        return $this;
    }

    public function makeJson() {
        return json_encode($this->callable_data);
    }

    public function gateway() {
        return $this->belongsTo(PaymentGateway::class,"payment_gateway_id");
    }

    public function getCryptoAttribute() {
        if($this->gateway->crypto == true) return true;
        return false;
    }

    public function getPaymentGatewayAliasAttribute()
    {
        return $this->gateway->alias;
    }
    
}
