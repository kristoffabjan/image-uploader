# Project Setup Guide

This guide will walk you through the process of setting up and running the project.

## Prerequisites

- Server with PHP
- Composer

## Getting Started

1. Clone the repository:

    ```bash
    git clone <repository-url>
    ```

2. Navigate to the project directory:

    ```bash
    cd <project-directory>
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```
    
4. Copy the environment configuration file and change variables according to your needs:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```
6. Start the Docker environment(optional if using Docker/Sail):

    ```bash
    ./vendor/bin/sail up -d
    ```

7. Run database migrations:

    ```bash
    php artisan migrate
    ```

8. Seed the database (optional):

    ```bash
    php artisan db:seed
    ```

9. Run tests to ensure everything is working:

    ```bash
    php artisan test
    ```

## Obtaining Access Token

To interact with the API, you need to obtain an access token.

1. Create an API user using the Artisan command:

    ```bash
    php artisan user:create example@example.com secret_password
    ```

    Replace `example@example.com` with the desired email address and `secret_password` with the desired password.

2. Obtain a token via a POST request to `/api/tokens/create`:

    Example:

    ```http
    POST /api/tokens/create
    Content-Type: application/json

    {
        "email": "example@example.com",
        "password": "secret_password"
    }
    ```

    Response:

    ```json
    {
        "token": "your-access-token"
    }
    ```

## Media Upload

To upload media, use the `/api/media-upload` endpoint with the obtained access token in the header:

- Method: POST
- Endpoint: `/api/media-upload`
- Headers:
    - `Authorization: Bearer your-access-token`
- Body:
    ```json
    {
        "title": "Your Media Title",
        "description": "Description of the media",
        "media": "media-file"
    }
    ```

    Replace `"media-file"` with your file.

    Response:

    ```json
    {
        "file_type": "image/jpeg",
        "size": "1.5MB",
        "path": "media/image.jpg"
    }
    ```