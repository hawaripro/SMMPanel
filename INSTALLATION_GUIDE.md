# Installation Guide for SMMPanel Laravel Vue.js Tailwind Migration Project

## Table of Contents
1. [System Requirements](#system-requirements)
2. [Software Installation](#software-installation)
   - [Windows](#windows)
   - [macOS/Linux](#macoslinux)
3. [Environment Setup](#environment-setup)
4. [Database Configuration](#database-configuration)
5. [Commands for Setting Up the Project](#commands-for-setting-up-the-project)

---

## System Requirements
- PHP >= 7.4
- Composer
- Node.js >= 14.x
- MySQL >= 5.7 or MariaDB

## Software Installation
### Windows
1. **Install Git**  
   [Download Git](https://git-scm.com/download/win) and follow the installation steps.

2. **Install XAMPP**  
   [Download XAMPP](https://www.apachefriends.org/index.html) and install it. Make sure Apache and MySQL are running.

3. **Install Node.js**  
   [Download Node.js](https://nodejs.org/en/download/) and follow the installation steps.

4. **Install Composer**  
   [Download Composer](https://getcomposer.org/download/) and follow the installation steps.

5. **Install Visual Studio Code**  
   [Download VS Code](https://code.visualstudio.com/) and install it.

### macOS/Linux
1. **Install Git**  
   ```bash
   brew install git  # For macOS
   sudo apt install git  # For Ubuntu
   ```

2. **Install XAMPP**  
   [Download XAMPP](https://www.apachefriends.org/index.html) and install it, or use the command line.

3. **Install Node.js**  
   ```bash
   brew install node  # For macOS
   sudo apt install nodejs  # For Ubuntu
   ```

4. **Install Composer**  
   ```bash
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"  
   php -r "if (hash_file('sha384', 'composer-setup.php') === 'your expected hash here') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"  
   php composer-setup.php  
   php -r "unlink('composer-setup.php');"  
   ```

5. **Install Visual Studio Code**  
   Follow instructions on [VS Code installation](https://code.visualstudio.com/docs/setup/setup-overview).

## Environment Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/hawaripro/SMMPanel.git
   cd SMMPanel
   ```

2. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```

3. Generate the application key:
   ```bash
   composer install
   php artisan key:generate
   ```

## Database Configuration
1. Create a new database in XAMPP or your MySQL environment.
2. Configure your `.env` file:
   ```plaintext
database=<your_database_name>
username=root
password=
   ```

## Commands for Setting Up the Project
1. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

2. Start the server:
   ```bash
   php artisan serve
   ```

3. Compile assets:
   ```bash
   npm install
   npm run dev
   ```

4. Access the application:
   Open your browser and navigate to [http://localhost:8000](http://localhost:8000) to see your application running.

---

This document serves as a comprehensive guide to setting up the SMMPanel Laravel Vue.js Tailwind migration project. Follow the instructions for your operating system carefully to ensure a successful installation.