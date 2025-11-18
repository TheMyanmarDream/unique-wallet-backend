<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birth_date',
        'phone_number',
        'gender',
        'qr_code',
        'wallet_qr_code',
        'plan',
        'benefit_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /**
     * Generate Wallet QR code for the user.
     */
    public function generateWalletQrCode(): string
    {
        // Generate QR code data with user ID
        $qrData = 'https://unique-wallet.on-forge.com/nova/resources/users/?user_id=' . $this->id;

        // Generate QR code using external service
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrData);

        // Download and save QR code locally
        $qrCodePath = 'qr_codes/wallet_user_' . $this->id . '.png';
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
    public function getWalletQrCodeUrlAttribute(): string
    {
        if (!$this->wallet_qr_code) {
            return '';
        }

        // If it's a file path, return the storage URL
        if (str_contains($this->wallet_qr_code, 'qr_codes/')) {
            return asset('storage/' . $this->wallet_qr_code);
        }

        // If it's just data, generate QR code URL on the fly
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($this->wallet_qr_code);
    }

    /**
     * Get QR code data for scanning.
     */
    public function getWalletQrCodeDataAttribute(): string
    {
        return 'https://unique-wallet.on-forge.com/nova/resources/users/?user_id=' . $this->id;
    }

    /**
     * Get the user's wallets.
     */
    public function userWallets()
    {
        return $this->hasMany(UserWallet::class);
    }
}
