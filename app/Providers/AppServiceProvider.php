<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Brand QR Code generation observer
        \App\Models\Brand::created(function ($brand) {
            $qrCodePath = $brand->generateQrCode();
            $brand->updateQuietly(['brand_qr_code' => $qrCodePath]);
        });

        \App\Models\Brand::updated(function ($brand) {
            if (empty($brand->brand_qr_code)) {
                $qrCodePath = $brand->generateQrCode();
                $brand->updateQuietly(['brand_qr_code' => $qrCodePath]);
            }
        });

        // User Wallet QR Code generation observer
        \App\Models\User::created(function ($user) {
            $qrCodePath = $user->generateWalletQrCode();
            $user->updateQuietly(['wallet_qr_code' => $qrCodePath]);
        });

        \App\Models\User::updated(function ($user) {
            if (empty($user->wallet_qr_code)) {
                $qrCodePath = $user->generateWalletQrCode();
                $user->updateQuietly(['wallet_qr_code' => $qrCodePath]);
            }
        });
    }
}
