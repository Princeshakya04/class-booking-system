<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\BookingModel;
use App\Models\ClassModel;
use App\Services\BookingValidationService;
use App\Traits\LoggerTrait;

class BookingController
{
    use LoggerTrait;

    private $bookingModel;
    private $classModel;
    private $validationService;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->classModel = new ClassModel();
        $this->validationService = new BookingValidationService();
    }

    public function book(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $this->log("Received booking request: " . json_encode($data));

        try {
            $this->validationService->validate($data);
            $className = $data['class_name'];
            $userName = $data['user_name'];
            $date = $data['date'];

            if (!$this->classModel->isClassScheduledForDate($className, $date)) {
                $this->log("No class scheduled for date: $date");
                $response->getBody()->write(json_encode(['error' => 'No class scheduled for this date.']));
                return $response->withStatus(404);
            }

            if (!$this->classModel->canBookClass($className, $date)) {
                $this->log("Class capacity full for class: $className on date: $date");
                $response->getBody()->write(json_encode(['error' => 'Class capacity is full.']));
                return $response->withStatus(409);
            }

            $this->classModel->addBooking($className, $date);
            $this->bookingModel->addBooking($userName, $className, $date);
            $this->log("Booking successful for user: $userName, class: $className on date: $date");
            $response->getBody()->write(json_encode(['message' => 'Booking successful']));
            return $response->withStatus(201);
        } catch (\InvalidArgumentException $e) {
            $this->log("Validation error: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400);
        }
    }
}