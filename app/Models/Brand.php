<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

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
        $qrData = 'BRAND_' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
        
        // Create QR code
        $qrCode = QrCode::create($qrData);
        $writer = new PngWriter();
        
        // Generate QR code and save as PNG
        $qrCodePath = 'qr_codes/brand_' . $this->id . '.png';
        $fullPath = storage_path('app/public/' . $qrCodePath);
        
        // Create directory if it doesn't exist
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }
        
        // Generate and save QR code
        $result = $writer->write($qrCode);
        $result->saveToFile($fullPath);
        
        return $qrCodePath;
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
