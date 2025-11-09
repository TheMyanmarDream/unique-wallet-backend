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
     * Generate QR code for the brand using HTTP service.
     */
    public function generateQrCode(): string
    {
        // Generate QR code data with brand ID
        $qrData = 'BRAND_' . str_pad($this->id, 6, '0', STR_PAD_LEFT);

        // Generate QR code using external service
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrData);

        // Download and save QR code locally
        $qrCodePath = 'qr_codes/brand_' . $this->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        // Create directory if it doesn't exist
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Download and save QR code
        $qrCodeContent = file_get_contents($qrCodeUrl);
        if ($qrCodeContent !== false) {
            file_put_contents($fullPath, $qrCodeContent);
            return $qrCodePath;
        }

        // If download fails, just return the data string
        return $qrData;
    }

    /**
     * Get QR code URL for display.
     */
    public function getQrCodeUrlAttribute(): string
    {
        if (!$this->brand_qr_code) {
            return '';
        }

        // If it's a file path, return the storage URL
        if (str_contains($this->brand_qr_code, 'qr_codes/')) {
            return asset('storage/' . $this->brand_qr_code);
        }

        // If it's just data, generate QR code URL on the fly
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($this->brand_qr_code);
    }

    /**
     * Generate QR code for the brand (Alternative: HTTP-based).
     */
    public function generateQrCodeAlternative(): string
    {
        // Generate QR code data with brand ID
        $qrData = 'BRAND_' . str_pad($this->id, 6, '0', STR_PAD_LEFT);

        // Generate QR code using external service
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrData);

        // Download and save QR code locally
        $qrCodePath = 'qr_codes/brand_' . $this->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);

        // Create directory if it doesn't exist
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Download and save QR code
        $qrCodeContent = file_get_contents($qrCodeUrl);
        if ($qrCodeContent !== false) {
            file_put_contents($fullPath, $qrCodeContent);
        }

        return $qrCodePath;
    }
}
