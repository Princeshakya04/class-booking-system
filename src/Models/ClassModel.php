<?php

namespace App\Models;

class ClassModel
{
    private $filePath = __DIR__ . '/classes.json';

    public function __construct()
    {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function addClass($className, $startDate, $endDate, $capacity)
    {
        $classes = $this->getClasses();

        if ($this->isClassScheduled($className, $startDate, $endDate)) {
            return false; // Class already scheduled for this date range
        }

        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $interval, $end->modify('+1 day'));

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $classes[$formattedDate] = [
                'class_name' => $className,
                'capacity' => $capacity,
                'bookings' => 0 // Initialize bookings count
            ];
        }

        file_put_contents($this->filePath, json_encode($classes));
        return true;
    }

    public function isClassScheduled($className, $startDate, $endDate)
    {
        $classes = $this->getClasses();
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $interval, $end->modify('+1 day'));

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            if (isset($classes[$formattedDate]) && $classes[$formattedDate]['class_name'] === $className) {
                return true; // Class with the same name already scheduled for this date
            }
        }
        return false;
    }

    public function isClassScheduledForDate($className, $date)
    {
        $classes = $this->getClasses();
        return isset($classes[$date]) && $classes[$date]['class_name'] === $className;
    }

    public function canBookClass($className, $date)
    {
        $classes = $this->getClasses();
        if (!$this->isClassScheduledForDate($className, $date)) {
            return false;
        }

        return $classes[$date]['bookings'] < $classes[$date]['capacity'];
    }

    public function addBooking($className, $date)
    {
        $classes = $this->getClasses();
        if ($this->canBookClass($className, $date)) {
            $classes[$date]['bookings']++;
            file_put_contents($this->filePath, json_encode($classes));
            return true;
        }
        return false;
    }

    public function getClasses()
    {
        return json_decode(file_get_contents($this->filePath), true);
    }
}