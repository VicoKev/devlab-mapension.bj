<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'payment_batch_id',
        'beneficiary_name',
        'beneficiary_id_type',
        'beneficiary_id_value',
        'currency',
        'amount',
        'home_transaction_id',
        'mojaloop_transaction_id',
        'status',
        'error_message',
        'mojaloop_response',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'mojaloop_response' => 'array',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(PaymentBatch::class, 'payment_batch_id');
    }
}
