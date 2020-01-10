<?php
/*
 * To Modify any functionality, Create a new class and extend it from the original
 * Then, change the namespaces and fqdn in below array
 * Implement only those methods you want to modify.
 *
 * You can also call parent's method before or after your own implementation, to get the benefit of the original function.
 */
return [
    'fqdn' => [
        'Criteria'        => 'RamzyVirani\RateAndReview\Criteria\ReviewCriteria',
        'DataTable'       => 'RamzyVirani\RateAndReview\DataTables\ReviewDataTable',
        'Model'           => 'RamzyVirani\RateAndReview\Models\Review',
        'AdminController' => 'RamzyVirani\RateAndReview\Controllers\Admin\ReviewController',
        'ApiController'   => 'RamzyVirani\RateAndReview\Controllers\Api\ReviewAPIController',
        'Repository'      => 'RamzyVirani\RateAndReview\Repositories\ReviewRepository',
    ]
];