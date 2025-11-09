<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'place',
        'brand_image',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'address',
        'google_map',
        'phone_number_1',
        'phone_number_2',
        'order_valid_status',
    ];

    protected $casts = [
        'order_valid_status' => 'boolean',
    ];

    /**
     * Get the admins for the brand.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * Get the user wallets for the brand.
     */
    public function userWallets(): HasMany
    {
        return $this->hasMany(UserWallet::class);
    }
}
