<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::macro('day_month_year', function () {
            return $this->format('d') . " de {$this->getTranslatedMonthName()} " . $this->format('Y');
        });

        Carbon::macro('day_name', function () {
            return Str::of($this->getTranslatedDayName())->ucfirst() . " $this->day";
        });

        Model::preventLazyLoading(function ($model, $relation) {
            $class = get_class($model);

            info("Attempted to lazy load [{$relation}] on model [{$class}].");
        });
    }
}
