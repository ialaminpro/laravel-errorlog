<?php
use Acolyte\ErrorLog\Http\Controllers\ErrorLogController;


Route::prefix(config('errorlog.ROUTE_PREFIX'))->group(function () {
    Route::middleware(config('errorlog.MIDDLEWARE')?config('errorlog.MIDDLEWARE'):'web')->group(function () {
        Route::namespace('Acolyte\ErrorLog')->group(function () {
            $laravel = app();
            $laravel_version = ($laravel::VERSION)[0];
            
            if($laravel_version <= 7) {
                Route::get('error-logs', 'ErrorLogController@index');
                Route::get('error-logs/delete/{id}', 'ErrorLogController@errorLogDelete');
                Route::post('error-logs/delete_all', 'ErrorLogController@errorLogDeleteAll');
                Route::get('error-logs/toggle-resolve/{id}', 'ErrorLogController@errorLogResolve');
            } else {
                Route::get('error-logs', [ErrorLogController::class, 'index']);
                Route::get('error-logs/delete/{id}', [ErrorLogController::class, 'errorLogDelete']);
                Route::post('error-logs/delete_all', [ErrorLogController::class, 'errorLogDeleteAll']);
                Route::get('error-logs/toggle-resolve/{id}', [ErrorLogController::class, 'errorLogResolve']);
            }
        });
    });
});
