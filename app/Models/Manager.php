<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{
    use HasFactory;

    protected $table = 'managers';
    protected $primaryKey = 'manager_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'manager_id',
        'manager_email',
        'manager_phone',
        'manager_name',
        'manager_surname',
        'company_logo',
        'company',
        'manager_pass',
        'manager_tax_kimlikno',
        'company_tax_number',
        'company_tax_office',
        'company_legal_name',
    ];

    /**
     * Menajerle ilişkili sanatçıları getirir
     */
    public function artists(): HasMany
    {
        return $this->hasMany(Artist::class, 'related_manager', 'manager_id');
    }

    /**
     * Menajer tam adını döndürür
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->manager_name} {$this->manager_surname}";
    }
} 