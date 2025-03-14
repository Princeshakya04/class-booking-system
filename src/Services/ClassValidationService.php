<?php

namespace App\Services;

use App\Exceptions\InvalidDateException;
use App\Exceptions\InvalidCapacityException;

class ClassValidationService
{
    public function validate($data)
    {
        $className = $data['class_name'] ?? null;
        $startDate = $data['start_date'] ?? null;
        $endDate = $data['end_date'] ?? null;
        $capacity = $data['capacity'] ?? null;

        if (!$className || !$startDate || !$endDate || !$capacity) {
            throw new \InvalidArgumentException('All fields are required.');
        }

        if (new \DateTime($endDate) <= new \DateTime($startDate)) {
            throw new InvalidDateException();
        }

        if (!is_numeric($capacity) || (int)$capacity <= 0) {
            throw new InvalidCapacityException();
        }

        return [
            'class_name' => $className,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => (int)$capacity
        ];
    }
}