<?php

use PHPUnit\Framework\TestCase;
use App\Models\ClassModel;

class ClassModelTest extends TestCase
{
    private $classModel;

    protected function setUp(): void
    {
        $this->classModel = new ClassModel();
        // Clear the classes.json file before each test
        file_put_contents(__DIR__ . '/../src/Models/classes.json', json_encode([]));
    }

    public function testAddClass()
    {
        $result = $this->classModel->addClass('Yoga', '2025-04-01', '2025-04-30', 10);
        $this->assertTrue($result);
    }

    public function testDuplicateClass()
    {
        $this->classModel->addClass('Yoga', '2025-04-01', '2025-04-30', 10);
        $result = $this->classModel->addClass('Yoga', '2025-04-01', '2025-04-30', 10);
        $this->assertFalse($result);
    }

    public function testIsClassScheduledForDate()
    {
        $this->classModel->addClass('Yoga', '2025-04-01', '2025-04-30', 10);
        $isScheduled = $this->classModel->isClassScheduledForDate('Yoga', '2025-04-15');
        $this->assertTrue($isScheduled);

        $isNotScheduled = $this->classModel->isClassScheduledForDate('Yoga', '2025-05-01');
        $this->assertFalse($isNotScheduled);
    }

    public function testCanBookClass()
    {
        $this->classModel->addClass('Yoga', '2025-04-01', '2025-04-30', 1);
        $canBook = $this->classModel->canBookClass('Yoga', '2025-04-15');
        $this->assertTrue($canBook);

        // Book the class to reach capacity
        $this->classModel->addBooking('Yoga', '2025-04-15');
        $cannotBook = $this->classModel->canBookClass('Yoga', '2025-04-15');
        $this->assertFalse($cannotBook);
    }

    public function testAddBooking()
    {
        $this->classModel->addClass('Yoga', '2025-04-01', '2025-04-30', 10);
        $added = $this->classModel->addBooking('Yoga', '2025-04-15');
        $this->assertTrue($added);

        $classes = $this->classModel->getClasses();
        $this->assertEquals(1, $classes['2025-04-15']['bookings']);
    }
}