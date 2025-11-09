<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Auth\PasswordValidationRules;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Collection;

class User extends Resource
{
    use PasswordValidationRules;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email', 'phone_number',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field|\Laravel\Nova\Panel|\Laravel\Nova\ResourceTool|\Illuminate\Http\Resources\MergeValue>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules($this->passwordRules())
                ->updateRules($this->optionalPasswordRules()),

            Date::make('Birth Date')
                ->nullable(),

            Text::make('Phone Number')
                ->rules('required', 'max:20'),

            Select::make('Gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                    'other' => 'Other',
                ])
                ->nullable(),

            Text::make('QR Code')
                ->hideFromIndex()
                ->nullable(),

            Image::make('Wallet QR Code')
                ->disk('public')
                ->readonly()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->help('Wallet QR code will be auto-generated when the user is saved'),

            Select::make('Plan')
                ->options([
                    'basic' => 'Basic',
                    'premium' => 'Premium',
                    'vip' => 'VIP',
                ])
                ->nullable(),

            Number::make('Benefit ID')
                ->default(1)
                ->nullable(),
        ];
    }

    /**
     * Fill a new model instance using the given request.
     */
    protected static function fillFields(NovaRequest $request, $model, Collection $fields): array
    {
        $fieldResults = parent::fillFields($request, $model, $fields);

        // Auto-generate Wallet QR code if it's a new user or QR code is empty
        if (!$model->exists || !$model->wallet_qr_code) {
            // Save the model first to get an ID if it's new
            if (!$model->exists) {
                $model->save();
            }
            $model->wallet_qr_code = $model->generateWalletQrCode();
        }

        return $fieldResults;
    }

    /**
     * Get the cards available for the request.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
