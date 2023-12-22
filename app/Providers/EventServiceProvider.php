<?php

namespace App\Providers;

use App\Models\Service\Report;
use App\Models\WorkShift\WorkShiftEmployee;
use App\Models\WorkShift\WorkShiftGood;
use App\Models\WorkShift\WorkShiftVisitor;
use App\Observers\ReportObserver;
use App\Observers\WorkShiftEmployeeObserver;
use App\Observers\WorkShiftGoodObserver;
use App\Observers\WorkShift\WorkShiftVisitorObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        Report::class => [
            ReportObserver::class,
        ],
        WorkShiftEmployee::class => [
            WorkShiftEmployeeObserver::class,
        ],
        WorkShiftGood::class => [
            WorkShiftGoodObserver::class,
        ],
        WorkShiftVisitor::class => [
            WorkShiftVisitorObserver::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
