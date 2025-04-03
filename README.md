# Suso - Image Analysis Platform

A Laravel-based platform for analyzing images using Google Cloud Vision and Gemini AI. The platform allows users to upload images and get detailed analysis of their content.

## Features

- User authentication and authorization
- Multiple file upload support
- Background job processing
- Image analysis using Google Cloud Vision
- Advanced analysis using Google Gemini AI
- Interactive data visualization
- Real-time status updates

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- PostgreSQL 12 or higher
- Google Cloud Vision API credentials
- Google Gemini API key

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/suso.git
cd suso
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=suso
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Configure Google Cloud Vision:
   - Create a service account in Google Cloud Console
   - Download the JSON key file
   - Place it in `storage/app/google-vision-key.json`
   - Add the path to your `.env`:
   ```env
   GOOGLE_VISION_KEY_PATH=storage/app/google-vision-key.json
   ```

8. Configure Google Gemini:
   - Get your API key from Google AI Studio
   - Add it to your `.env`:
   ```env
   GEMINI_API_KEY=your_gemini_api_key
   ```

9. Run migrations:
```bash
php artisan migrate
```

10. Create storage link:
```bash
php artisan storage:link
```

11. Start the queue worker:
```bash
php artisan queue:work
```

12. Start the development server:
```bash
php artisan serve
```

## Database Structure

The project uses PostgreSQL with the following main tables:

- `users`: User authentication and profile information
- `uploads`: Main upload records with analysis results
- `uploaded_images`: Individual image records
- `jobs`: Queue job records

## Job Processing

The application uses Laravel's queue system for background processing:

1. `UploadJob`: Handles initial file processing
2. `AnalyseUploadJob`: Processes images using Google Cloud Vision and Gemini AI

To monitor jobs:
```bash
php artisan queue:monitor
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Laravel Framework
- Google Cloud Vision API
- Google Gemini AI
- Chart.js for data visualization
