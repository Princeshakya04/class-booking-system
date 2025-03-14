# Glofox API

This project is a PHP-based application using the Slim framework. It provides services for class validation and management, allowing users to create and book classes with defined capacities.

## Prerequisites

- Docker
- Docker Compose

## Setup

1. **Clone the Repository**

   Clone this repository to your local machine:

   ```bash
   git clone https://github.com/Princeshakya04/class-booking-system.git
   cd glofox-api
   ```

2. **Build the Docker Image**

   Build the Docker image using the provided `Dockerfile` and `docker-compose.yml`:

   ```bash
   docker-compose build
   ```

3. **Install Dependencies**

   The dependencies are installed automatically when the Docker image is built. If you need to install them manually, you can run:

   ```bash
   docker-compose run --rm app composer install
   ```

## Running the Application

1. **Start the Application**

   Start the application using Docker Compose:

   ```bash
   docker-compose up
   ```

   The application will be available at `http://localhost:8000`.

## Running Tests

1. **Run PHPUnit Tests**

   To run the PHPUnit tests, execute the following command inside the Docker container:

   ```bash
   docker-compose run --rm app vendor/bin/phpunit tests
   ```

   This will run all the test cases located in the `tests` directory.

## Additional Information

- **Environment Variables**

  The application uses environment variables defined in the `docker-compose.yml` file. You can modify these as needed for different environments.

- **Logs**

  Application logs are stored in `logs/app.log`.

- **API Documentation**

  For detailed API information, refer to the [API_DOCUMENTATION.md](API_DOCUMENTATION.md) file.

## Troubleshooting

- If you encounter any issues with Docker, ensure that Docker and Docker Compose are installed and running correctly on your system.
- For any PHP-related issues, check the logs in `logs/app.log` for more details.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.