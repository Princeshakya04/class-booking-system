<?php

namespace App\Services;

class BookingValidationService
{
    public function validate($data)
    {
        $className = $data['class_name'] ?? null;
        $userName = $data['user_name'] ?? null;
        $date = $data['date'] ?? null;

        if (empty($className) || !is_string($className)) {
            throw new \InvalidArgumentException('Class name is required and must be a string.');
        }

        if (empty($userName) || !is_string($userName)) {
            throw new \InvalidArgumentException('User name is required and must be a string.');
        }

        if (empty($date) || !$this->isValidDate($date)) {
            throw new \InvalidArgumentException('A valid date is required.');
        }
    }

    private function isValidDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}