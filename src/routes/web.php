<?php

Route::prefix(config('errorlog.ROUTE_PREFIX'))->group(function () {
    Route::middleware(config('errorlog.MIDDLEWARE')?config('errorlog.MIDDLEWARE'):'web')->group(function () {
        Route::namespace('Acolyte\ErrorLog')->group(function () {
            Route::get('error-logs', 'ErrorLogController@index');
            Route::get('error-logs/delete/{id}', 'ErrorLogController@errorLogDelete');
            Route::post('error-logs/delete_all', 'ErrorLogController@errorLogDeleteAll');
            Route::get('error-logs/toggle-resolve/{id}', 'ErrorLogController@errorLogResolve');
        });
    });
});