<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('char', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && strlen($value) === 2;
        });

        // Extender las reglas de validación con una regla personalizada 'validatedprovince'
        Validator::extend('validatedprovince', function ($attribute, $value, $parameters, $validator) {
            // Asegurarse de que el valor tenga 2 caracteres (rellenando con ceros si es necesario)
            return is_string($value) && strlen($value) == 2 && is_numeric($value);
        });

        // Agregar el 'validatedprovince' como un error en español (opcional)
        Validator::replacer('validatedprovince', function ($message, $attribute, $rule, $parameters) {
            return "El campo {$attribute} debe tener dos dígitos numéricos.";
        });
    }
}
