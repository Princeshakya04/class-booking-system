<?php

use PHPUnit\Framework\TestCase;
use App\Models\BookingModel;

class BookingModelTest extends TestCase
{
    private $bookingModel;

    protected function setUp(): void
    {
        $this->bookingModel = new BookingModel();
        // Clear the bookings.json file before each test
        file_put_contents(__DIR__ . '/../src/Models/bookings.json', json_encode([]));
    }

    public function testAddBooking()
    {
        $this->bookingModel->addBooking('John Doe', 'Yoga', '2025-04-15');
        $bookings = $this->bookingModel->getBookings();

        $this->assertCount(1, $bookings);
        $this->assertEquals('John Doe', $bookings[0]['user_name']);
        $this->assertEquals('Yoga', $bookings[0]['class_name']);
        $this->assertEquals('2025-04-15', $bookings[0]['date']);
    }

    public function testAddMultipleBookings()
    {
        $this->bookingModel->addBooking('John Doe', 'Yoga', '2025-04-15');
        $this->bookingModel->addBooking('Jane Smith', 'Pilates', '2025-04-16');
        $bookings = $this->bookingModel->getBookings();

        $this->assertCount(2, $bookings);

        $this->assertEquals('John Doe', $bookings[0]['user_name']);
        $this->assertEquals('Yoga', $bookings[0]['class_name']);
        $this->assertEquals('2025-04-15', $bookings[0]['date']);

        $this->assertEquals('Jane Smith', $bookings[1]['user_name']);
        $this->assertEquals('Pilates', $bookings[1]['class_name']);
        $this->assertEquals('2025-04-16', $bookings[1]['date']);
    }

    public function testGetBookingsWhenEmpty()
    {
        $bookings = $this->bookingModel->getBookings();
        $this->assertIsArray($bookings);
        $this->assertCount(0, $bookings);
    }
}
