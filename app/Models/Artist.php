<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artist extends Model
{
    use HasFactory;

    protected $table = 'artists';
    protected $primaryKey = 'artist_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'artist_id',
        'artist_name',
        'related_manager',
        'artist_image',
        'genre',
        'artist_slug',
        'subscription_plan',
    ];

    /**
     * Sanatçının ait olduğu menajer
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'related_manager', 'manager_id');
    }

    /**
     * Sanatçının abonelik planı
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan', 'plan_id');
    }
} 