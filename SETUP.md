# SMMPanel Setup Guide

## Prerequisites
- PHP >= 7.4
- Composer
- Node.js >= 12.x
- NPM
- MySQL or MariaDB

## Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/hawaripro/SMMPanel.git
   cd SMMPanel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment**
   - Copy the `.env.example` file to `.env`
   - Update your `.env` file with the appropriate database and application settings.

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Install front-end dependencies**
   ```bash
   npm install
   ```

7. **Build assets**
   ```bash
   npm run dev
   ```

8. **Run the application**
   ```bash
   php artisan serve
   ```
   Access the application at `http://localhost:8000`

## Project Structure
- `app/`: Contains the core application code.
- `config/`: Configuration files for various services.
- `database/`: Migrations and factories.
- `resources/`: Views, assets, and language files.
- `routes/`: All route definitions.
- `public/`: Publicly accessible files.

## Contributing
1. Fork the project
2. Create your feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a pull request