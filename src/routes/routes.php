<?php
/** Api Routes */
Route::prefix('api')
    ->middleware('api')
    ->as('api.')
    ->namespace(RamzyVirani\RateAndReview\Helper\Util::getNameSpaceFromConfig('ApiController'))
    ->group(function () {
        Route::get('v1/reviews',
            RamzyVirani\RateAndReview\Helper\Util::getClassNameFromConfig('ApiController') . '@index'
        )->named('index');
        Route::get('v1/reviews/{id}',
            RamzyVirani\RateAndReview\Helper\Util::getClassNameFromConfig('ApiController') . '@show'
        )->named('show');

        /** Token Required */
        Route::middleware('auth:api')->group(function () {
            Route::post('v1/reviews',
                RamzyVirani\RateAndReview\Helper\Util::getClassNameFromConfig('ApiController') . '@store'
            )->named('store');
        });
    });

/** Admin Routes */
Route::prefix('admin')
    ->middleware('web', 'checkAdminPermission')
    ->as('admin.')
    ->namespace(RamzyVirani\RateAndReview\Helper\Util::getNameSpaceFromConfig('AdminController'))
    ->group(function () {
        Route::resource('reviews',
            RamzyVirani\RateAndReview\Helper\Util::getClassNameFromConfig('AdminController')
        );
    });
