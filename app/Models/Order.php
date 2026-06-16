<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_tier',
        'shipping_fee',
        'payment_method',
        'payment_status',
        'shipping_address',
        'recipient_name',
        'recipient_phone',
        'payment_expires_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'payment_expires_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function booted()
    {
        static::updating(function ($order) {
            if ($order->isDirty('status')) {
                if ($order->status === 'Completed' && is_null($order->delivered_at)) {
                    $order->delivered_at = now();
                }
                if ($order->status === 'Cancelled' && is_null($order->cancelled_at)) {
                    $order->cancelled_at = now();
                }
                if ($order->status === 'Paid') {
                    $order->payment_status = 'Paid';
                }
            }
        });
    }
}
