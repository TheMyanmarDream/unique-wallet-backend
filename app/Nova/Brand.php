<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Collection;

class Brand extends Resource
{
    public static $model = \App\Models\Brand::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'place',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Textarea::make('Description')
                ->nullable(),

            Textarea::make('Place')
                ->nullable(),

            Image::make('Brand Image')
                ->disk('public')
                ->rules('required', 'image', 'max:2048'),

            Image::make('Brand QR Code')
                ->disk('public')
                ->readonly()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->help('QR code will be auto-generated when the brand is saved'),

            Select::make('Monday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Select::make('Tuesday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Select::make('Wednesday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Select::make('Thursday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Select::make('Friday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Select::make('Saturday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Select::make('Sunday')
                ->options([
                    'Close' => 'Close',
                    '9:00 AM - 5:00 PM' => '9:00 AM - 5:00 PM',
                    '10:00 AM - 6:00 PM' => '10:00 AM - 6:00 PM',
                    '8:00 AM - 8:00 PM' => '8:00 AM - 8:00 PM',
                ])
                ->default('Close'),

            Textarea::make('Address')
                ->nullable(),

            Textarea::make('Google Map')
                ->nullable(),

            Text::make('Phone Number 1')
                ->nullable(),

            Text::make('Phone Number 2')
                ->nullable(),

            Boolean::make('Order Valid Status')
                ->default(false),

            HasMany::make('Admins'),
            HasMany::make('User Wallets', 'userWallets', UserWallet::class),
        ];
    }

    /**
     * Fill a new model instance using the given request.
     */
    protected static function fillFields(NovaRequest $request, $model, Collection $fields): array
    {
        $fieldResults = parent::fillFields($request, $model, $fields);

        // Auto-generate QR code if it's a new brand or QR code is empty
        if (!$model->exists || !$model->brand_qr_code) {
            // Save the model first to get an ID if it's new
            if (!$model->exists) {
                $model->save();
            }
            $model->brand_qr_code = $model->generateQrCode();
        }

        return $fieldResults;
    }
}
