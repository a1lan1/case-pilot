<?php

declare(strict_types=1);

use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/user', fn (Request $request) => $request->user());

    // Notifications
    Route::prefix('notifications')->name('api.notifications.')->group(function (): void {
        Route::get('', [NotificationController::class, 'index'])->name('index');
        Route::post('read', [NotificationController::class, 'markAllAsRead'])->name('read_all');
        Route::post('{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::delete('{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });
});
