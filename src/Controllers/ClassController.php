<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Traits\LoggerTrait;
use App\Models\ClassModel;
use App\Services\ClassValidationService;
use App\Exceptions\InvalidDateException;
use App\Exceptions\InvalidCapacityException;

class ClassController
{
    use LoggerTrait;

    private $classModel;
    private $classValidationService;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->classValidationService = new ClassValidationService();
    }

    public function create(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $this->log("Received data: " . json_encode($data));

        try {
            $validatedData = $this->classValidationService->validate($data);
        } catch (\InvalidArgumentException $e) {
            $this->log("Invalid input detected");
            $response->getBody()->write(json_encode(['error' => 'All fields are required.']));
            return $response->withStatus(400);
        } catch (InvalidDateException $e) {
            $this->log("Invalid date detected");
            $response->getBody()->write(json_encode(['error' => 'End date must be after start date']));
            return $response->withStatus(400);
        } catch (InvalidCapacityException $e) {
            $this->log("Invalid capacity detected");
            $response->getBody()->write(json_encode(['error' => 'Capacity must be a positive number']));
            return $response->withStatus(400);
        }

        $className = $validatedData['class_name'];
        $startDate = $validatedData['start_date'];
        $endDate = $validatedData['end_date'];
        $capacity = $validatedData['capacity'];

        if ($this->classModel->isClassScheduled($className, $startDate, $endDate)) {
            $this->log("Class with the same name already scheduled for the date range");
            $response->getBody()->write(json_encode(['error' => "Class with the same name already scheduled for the date range"]));
            return $response->withStatus(409);
        }

        if (!$this->classModel->addClass($className, $startDate, $endDate, $capacity)) {
            $this->log("Class already scheduled for one of the dates");
            $response->getBody()->write(json_encode(['error' => "Class already scheduled for one of the dates"]));
            return $response->withStatus(409);
        }

        $response->getBody()->write(json_encode(['message' => 'Class created successfully']));
        return $response->withStatus(201);
    }
}