# bitdif

bitdif is a free and open-source, self-hosted image hosting platform similar to Imgur. It is built with Laravel 11 on the backend and Vue 3 on the frontend. bitdif allows you to upload, share, and manage images effortlessly on your own server.

<p align="center">
    <img src="https://bitdif.com/logo/logo.svg" alt="bitdif Logo" width="200">
</p>

## Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)

## Features

- **Self-Hosted**: Full control over your image hosting solution.
- **Modern Stack**: Built with Laravel 11 and Vue 3.
- **Responsive Design**: Mobile-friendly user interface.
- **Image Management**: Upload, delete, and organize your images.
- **User Authentication**: Secure login and registration system.
- **Drag and Drop Uploads**: Easy image uploads with drag and drop.
- **Image Sharing**: Generate shareable links for your images.
- **API Support**: Fully-featured API for integration with other applications.
- **ShareX Support**: Direct integration with ShareX for easy screenshot uploads.

## Screenshots

![](https://bitdif.com/08e65ba1.png "Gallery Browsing")
![](https://bitdif.com/916e13c8.png "Upload Page")
![](https://bitdif.com/e650340e.png "Basic Settings")
![](https://bitdif.com/88a92a40.png "View Image In Gallery")

You can check out a live demo of bitdif at [bitdif.com](https://bitdif.com).

## Requirements

- PHP 8.0 or higher
- Composer
- Node.js and npm
- MySQL or MariaDB, SQLite, or PostgreSQL
- A web server (e.g., Apache, Nginx)

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/jnewing/bitdif.git
    cd bitdif
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Set up environment variables:**

    Copy the `.env.example` file to `.env` and fill in your database and other required configurations.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Run database migrations:**

    ```bash
    php artisan migrate
    ```

5. **Build frontend assets:**

    ```bash
    npm run dev
    ```

6. **Start the development server:**

    ```bash
    php artisan serve
    ```

    ```bash
    npm run dev
    ```

Your bitdif instance should now be up and running at `http://localhost:8000`.

## Configuration

To configure bitdif, you can edit the `.env` file and set the following environment variables:

- `APP_NAME`: Your application name
- `APP_ENV`: Environment (local, production)
- `APP_KEY`: Application key
- `APP_DEBUG`: Debug mode (true/false)
- `DB_CONNECTION`: Database connection (mysql)
- `DB_HOST`: Database host
- `DB_PORT`: Database port
- `DB_DATABASE`: Database name
- `DB_USERNAME`: Database username
- `DB_PASSWORD`: Database password
- `APP_GEN_THUMBNAILS`: Generate thumbnails for images (true/false)
- `APP_ALLOW_REGISTRATION`: Allow user registration (true/false)
- `APP_ALLOW_UPLOAD_VIA_PASTE`: Allow image uploads via paste (true/false)
- `APP_ENABLE_API`: Enable the API (true/false)
- `APP_ENABLE_IMAGE_CACHING`: Enable image caching (true/false)

## Usage

### Uploading Images

1. Log in to your bitdif account.
2. Click the "Upload" button.
3. Drag and drop images or click to select files.
4. Manage your uploaded images from the dashboard.

### Sharing Images

1. After uploading an image, click on the image to view it.
2. Use the shareable link to share the image with others.

## API

bitdif provides a RESTful API that allows you to integrate image hosting capabilities into your own applications. You can use the API to upload, delete, and manage images programmatically.

### API Endpoints

- **Upload Image:** `POST /api/images`
- **Get Image:** `GET /api/images/{id}`

### Authentication

The API uses token-based authentication. To use the API, you will need to generate an API token from your bitdif account settings and include it in your requests.

#### Example Request

```bash
curl -X POST https://bitdif.com/api/v1/upload \
     -H "Authorization: Bearer YOUR_API_TOKEN" \
     -F "image=@path_to_image.jpg"
```

## ShareX Integration

bitdif supports direct integration with ShareX, a popular screenshot and screen recording tool for Windows. This allows you to upload screenshots directly to your bitdif server.

## Contributing

Contributions are welcome! To contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature-branch-name`.
3. Make your changes and commit them: `git commit -m 'Add new feature'`.
4. Push to the branch: `git push origin feature-branch-name`.
5. Create a pull request.

Please make sure to update tests as appropriate.

## License

bitdif is open-sourced software licensed under the [MIT license](LICENSE).

## Support

If you encounter any issues or have questions, feel free to open an issue on GitHub.

---

Thank you for using bitdif! We hope it serves your image hosting needs well.
