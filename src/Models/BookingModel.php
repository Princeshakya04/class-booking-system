<?php

namespace App\Models;

class BookingModel
{
    private $filePath = __DIR__ . '/bookings.json';

    public function __construct()
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function addBooking($userName, $className, $date)
    {
        $bookings = $this->getBookings();
        $bookings[] = [
            'user_name' => $userName,
            'class_name' => $className,
            'date' => $date
        ];
        file_put_contents($this->filePath, json_encode($bookings));
    }

    public function getBookings()
    {
        return json_decode(file_get_contents($this->filePath), true);
    }
}