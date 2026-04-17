<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Support\Facades\Schema;
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
        if ($this->app->runningInConsole()) {
            return;
        }

        if (!Schema::hasTable('bookings') || !Schema::hasTable('slot_jadwals') || !Schema::hasTable('booking_slots')) {
            return;
        }

        Booking::autoCancelPendingHPlusTwo();
    }
}
