<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'supabase_user_id',
        'subscription_plan_id',
        'iyzico_subscription_reference',
        'status',
        'trial_ends_at',
        'current_period_starts_at',
        'current_period_ends_at',
        'canceled_at',
        'cancel_at_period_end',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'current_period_starts_at' => 'datetime',
        'current_period_ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'cancel_at_period_end' => 'boolean',
    ];

    /**
     * Aboneliğin planını getir
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Aboneliğin aktif olup olmadığını kontrol eder
     */
    public function isActive(): bool
    {
        return $this->status === 'active' || $this->onTrial();
    }

    /**
     * Aboneliğin deneme süresinde olup olmadığını kontrol eder
     */
    public function onTrial(): bool
    {
        return $this->status === 'trial' && $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Aboneliğin iptal edilip edilmediğini kontrol eder
     */
    public function isCanceled(): bool
    {
        return $this->canceled_at !== null;
    }

    /**
     * Aboneliğin süresi dolduğunda iptal edilecek olup olmadığını kontrol eder
     */
    public function willCancelAtPeriodEnd(): bool
    {
        return $this->cancel_at_period_end;
    }

    /**
     * Aboneliği aktif hale getirir
     */
    public function markAsActive(): self
    {
        $this->status = 'active';
        $this->save();
        
        return $this;
    }

    /**
     * Aboneliği iptal edildi olarak işaretler
     */
    public function markAsCanceled(): self
    {
        $this->status = 'canceled';
        $this->canceled_at = now();
        $this->save();
        
        return $this;
    }

    /**
     * Aboneliğin dönem sonunda iptal edilmesini sağlar
     */
    public function cancelAtPeriodEnd(): self
    {
        $this->cancel_at_period_end = true;
        $this->save();
        
        return $this;
    }
}
