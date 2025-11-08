<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Brand extends Resource
{
    public static $model = \App\Models\Brand::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Description')
                ->nullable(),

            HasMany::make('Admins'),
        ];
    }
}
