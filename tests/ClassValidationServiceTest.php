<?php

use PHPUnit\Framework\TestCase;
use App\Services\ClassValidationService;
use App\Exceptions\InvalidDateException;
use App\Exceptions\InvalidCapacityException;

class ClassValidationServiceTest extends TestCase
{
    private $validationService;

    protected function setUp(): void
    {
        $this->validationService = new ClassValidationService();
    }

    public function testValidData()
    {
        $data = [
            'class_name' => 'Yoga',
            'start_date' => '2025-04-01',
            'end_date' => '2025-04-30',
            'capacity' => 10
        ];

        $result = $this->validationService->validate($data);
        $this->assertEquals($data['class_name'], $result['class_name']);
        $this->assertEquals($data['start_date'], $result['start_date']);
        $this->assertEquals($data['end_date'], $result['end_date']);
        $this->assertEquals($data['capacity'], $result['capacity']);
    }

    public function testInvalidDate()
    {
        $this->expectException(InvalidDateException::class);

        $data = [
            'class_name' => 'Yoga',
            'start_date' => '2025-04-30',
            'end_date' => '2025-04-01',
            'capacity' => 10
        ];

        $this->validationService->validate($data);
    }

    public function testInvalidCapacity()
    {
        $this->expectException(InvalidCapacityException::class);

        $data = [
            'class_name' => 'Yoga',
            'start_date' => '2025-04-01',
            'end_date' => '2025-04-30',
            'capacity' => 'invalid'
        ];

        $this->validationService->validate($data);
    }
}