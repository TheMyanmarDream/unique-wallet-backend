<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Illuminate\Support\Collection;

class UserWallet extends Resource
{
    public static $model = \App\Models\UserWallet::class;

    public static $title = 'id';

    public static $search = [
        'id', 'amount',
    ];

    /**
     * Build an "index" query for the given resource.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $admin = auth('admin')->user();
        
        if (!$admin) {
            return $query->whereNull('id'); // Return no results if not authenticated
        }
        
        // Check if admin has Finance Manager role
        if ($admin->roles()->where('name', 'Finance Manager')->exists()) {
            // Finance Manager can see all wallet entries
            return $query;
        }
        
        // Check if admin has Manager role
        if ($admin->roles()->where('name', 'Manager')->exists()) {
            // Manager can only see entries for their specific brand
            return $query->where('brand_id', $admin->brand_id);
        }
        
        // For other roles, only show entries for their brand
        return $query->where('brand_id', $admin->brand_id);
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('User')
                ->searchable()
                ->rules('required'),

            Currency::make('Amount')
                ->currency('USD')
                ->sortable()
                ->rules('required', 'numeric', 'min:0'),

            BelongsTo::make('Brand')
                ->default(auth('admin')->user()->brand_id ?? null)
                ->readonly()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            BelongsTo::make('Admin')
                ->default(auth('admin')->user()->id ?? null)
                ->readonly()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Created At')
                ->onlyOnDetail(),

            DateTime::make('Updated At')
                ->onlyOnDetail(),
        ];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Fill a new model instance using the given request.
     */
    protected static function fillFields(NovaRequest $request, $model, Collection $fields): array
    {
        $fieldResults = parent::fillFields($request, $model, $fields);

        // Set admin_id and brand_id from authenticated admin using admin guard
        $admin = auth('admin')->user();
        if ($admin) {
            $model->admin_id = $admin->id;
            $model->brand_id = $admin->brand_id;
        }

        return $fieldResults;
    }
}
