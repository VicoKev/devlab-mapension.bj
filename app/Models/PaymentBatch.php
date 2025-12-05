<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentBatch extends Model
{
    protected $fillable = [
        'batch_reference',
        'filename',
        'total_records',
        'successful_payments',
        'failed_payments',
        'pending_payments',
        'total_amount',
        'status',
        'started_at',
        'completed_at',
        'invalid_records',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'invalid_records' => 'array',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function updateStatistics(): void
    {
        $this->successful_payments = $this->payments()->where('status', 'success')->count();
        $this->failed_payments = $this->payments()->where('status', 'failed')->count();
        $this->pending_payments = $this->payments()->whereIn('status', ['pending', 'processing'])->count();

        if ($this->pending_payments === 0) {
            $this->status = $this->failed_payments === 0 ? 'completed' : 'partially_completed';
            $this->completed_at = now();
        }

        $this->save();
    }
}
