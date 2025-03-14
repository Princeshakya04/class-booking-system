<?php

use PHPUnit\Framework\TestCase;
use App\Services\BookingValidationService;

class BookingValidationServiceTest extends TestCase
{
    private $validationService;

    protected function setUp(): void
    {
        $this->validationService = new BookingValidationService();
    }

    public function testValidData()
    {
        $data = [
            'class_name' => 'Yoga',
            'user_name' => 'John Doe',
            'date' => '2025-04-15'
        ];

        // No exception should be thrown for valid data
        $this->validationService->validate($data);
        $this->assertTrue(true); // If no exception, the test passes
    }

    public function testMissingClassName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Class name is required and must be a string.');

        $data = [
            'user_name' => 'John Doe',
            'date' => '2025-04-15'
        ];

        $this->validationService->validate($data);
    }

    public function testInvalidClassName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Class name is required and must be a string.');

        $data = [
            'class_name' => 123, // Invalid class name
            'user_name' => 'John Doe',
            'date' => '2025-04-15'
        ];

        $this->validationService->validate($data);
    }

    public function testMissingUserName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('User name is required and must be a string.');

        $data = [
            'class_name' => 'Yoga',
            'date' => '2025-04-15'
        ];

        $this->validationService->validate($data);
    }

    public function testInvalidUserName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('User name is required and must be a string.');

        $data = [
            'class_name' => 'Yoga',
            'user_name' => 123, // Invalid user name
            'date' => '2025-04-15'
        ];

        $this->validationService->validate($data);
    }

    public function testMissingDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid date is required.');

        $data = [
            'class_name' => 'Yoga',
            'user_name' => 'John Doe'
        ];

        $this->validationService->validate($data);
    }

    public function testInvalidDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A valid date is required.');

        $data = [
            'class_name' => 'Yoga',
            'user_name' => 'John Doe',
            'date' => 'invalid-date' // Invalid date
        ];

        $this->validationService->validate($data);
    }
}
