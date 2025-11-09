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
}
