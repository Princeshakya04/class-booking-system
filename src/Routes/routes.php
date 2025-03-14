<?php

use Slim\App;
use App\Controllers\ClassController;
use App\Controllers\BookingController;

return function (App $app) {
    $app->post('/classes', [ClassController::class, 'create']);
    $app->post('/bookings', [BookingController::class, 'book']);
}; 