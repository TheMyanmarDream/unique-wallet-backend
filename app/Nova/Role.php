<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Resource;

class Role extends Resource
{
    public static $model = \App\Models\Role::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'slug',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->sortable()
                ->rules('required', 'max:255', 'unique:roles,slug,{{resourceId}}'),

            Textarea::make('Description')
                ->nullable(),

            BelongsToMany::make('Admins')
                ->fields(function () {
                    return [
                        // Add any pivot fields here if needed
                    ];
                }),
        ];
    }
}
