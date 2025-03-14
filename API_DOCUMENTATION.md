# API Documentation

## Overview

This document provides details on the available API endpoints for managing class schedules and bookings. The API allows users to create classes and book them, ensuring that class capacities are respected.

## Base URL

All endpoints are relative to the base URL: http://yourdomain.com/api

## Endpoints

1. Create a Class

* Endpoint: /classes
* Method: POST
* Description: Creates a new class with a specified name, date range, and capacity.
* Request Body:
  ``` 
  {
      "class_name": "Yoga",
      "start_date": "2025-04-01",
      "end_date": "2025-04-30",
      "capacity": 20
  }
* Response
    * 201 Created: Class created successfully.
    ```
    {
        "message": "Class created successfully"
    }
    ```
    * 400 Bad Request: Validation error.
    ```
    {
        "error": "All fields are required."
    }
    ```
    * 400 Bad Request: Invalid date range.
    ```
    {
        "error": "End date must be after start date"
    }
    ```
    * 400 Bad Request: Invalid capacity.
    ``` 
    {
        "error": "Capacity must be a positive number"
    }
    ```
    * 409 Conflict: Class already scheduled.
    ``` 
    {
        "error": "Class with the same name already scheduled for the date range"
    }
    ```
2. Book a Class
* Endpoint: /bookings
* Method: POST
* Description: Books a class for a user on a specified date.
* Request Body:
    ```
    {
      "class_name": "Yoga",
      "user_name": "John Doe",
      "date": "2025-04-15"
    }
    ```
* Responses:
    * 201 Created: Booking successful.
    ```
    {
        "message": "Booking successful"
    }
    ```
    * 400 Bad Request: Validation error.
    ```
    {
        "error": "Class name is required and must be a string."
    }
    ```
    * 404 Not Found: No class scheduled for the date.
    ```
    {
        "error": "No class scheduled for this date."
    }
    ```
    * 409 Conflict: Class capacity is full.
    ```
    {
        "error": "Class capacity is full."
    }
    ```

## Error Handling

* All error responses include an error field with a descriptive message.
* HTTP status codes are used to indicate the type of error:
    * 400 for validation errors.
    * 404 when a resource is not found.
    * 409 for conflicts, such as when a class is already scheduled or capacity is full.

## Notes

* Ensure that the server is running and accessible at the specified base URL.
* Dates should be in the YYYY-MM-DD format.
* Capacity must be a positive integer.

## Logging

* The application logs all requests and errors for debugging purposes. Logs are stored in a file specified by the LoggerTrait.


