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
        'brand_qr_code',
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

    /**
     * Generate QR code for the brand.
     */
    public function generateQrCode(): string
    {
        // Generate QR code data with brand ID
        return 'BRAND_' . str_pad($this->id, 6, '0', STR_PAD_LEFT) . '_' . time();
    }

    /**
     * Get QR code URL for display.
     */
    public function getQrCodeUrlAttribute(): string
    {
        if (!$this->brand_qr_code) {
            return '';
        }
        
        // You can use any QR code generation service
        // Example using Google Charts API (for demo purposes)
        return 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($this->brand_qr_code);
    }
}
