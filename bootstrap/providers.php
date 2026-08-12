<?php

use App\Modules\Assignment\Providers\AssignmentServiceProvider;
use App\Modules\Case\Providers\CaseServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\PrometheusServiceProvider;

return [
    AppServiceProvider::class,
    EventServiceProvider::class,
    AdminPanelProvider::class,
    FortifyServiceProvider::class,
    HorizonServiceProvider::class,
    PrometheusServiceProvider::class,
    CaseServiceProvider::class,
    AssignmentServiceProvider::class,
];
