<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    // Laravel veritabanı için eski özellikler
    // Protected $fillable = ...

    // Supabase tablosu için yeni özellikler
    protected $table = 'subscription_plans';
    protected $primaryKey = 'plan_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'plan_id',
        'plan_name',
        'max_members',
        'monthly_price',
        'price_currency',
        'plan_desc',
        'plan_features',
        'annual_price',
    ];

    protected $casts = [
        'max_members' => 'integer',
        'monthly_price' => 'float',
        'plan_features' => 'array',
    ];

    /**
     * Bu plana sahip sanatçıları getirir
     */
    public function artists(): HasMany
    {
        return $this->hasMany(Artist::class, 'subscription_plan', 'plan_id');
    }

    /**
     * Planın maksimum üye sayısını kontrol eder
     */
    public function hasReachedMemberLimit(string $managerId): bool
    {
        $currentCount = Artist::where('related_manager', $managerId)
            ->where('subscription_plan', $this->plan_id)
            ->count();
            
        return $currentCount >= $this->max_members;
    }

    /**
     * Plan özelliklerini kontrol eder
     */
    public function hasFeature(string $feature): bool
    {
        if (!isset($this->plan_features[$feature])) {
            return false;
        }
        
        return $this->plan_features[$feature] === 'yes';
    }
}
