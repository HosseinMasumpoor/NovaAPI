# NovaAPI

**NovaAPI** is a lightweight and powerful mini-framework for building APIs in PHP.  
Inspired by modern architectures and leveraging tools like Symfony and Eloquent, it provides a solid foundation for fast API development.

---

## ✨ Features

✅ **Service Container** for dependency management  
✅ **Service Providers** for extensibility  
✅ **Routing system** based on Symfony Routing  
✅ **Queue and Job** for background processing  
✅ **Localization** for multilingual support  
✅ **Facade Design Pattern** for a simplified API  
✅ **Caching** using file and Redis drivers  
✅ **Config manager** with caching support  
✅ **Eloquent ORM** for database interactions  
✅ **Logging system**  
✅ **Middleware system** with easy extensibility  
✅ **Authentication system** with customizable drivers  
✅ **OTP + JWT-based authentication service** built-in

---

## ⚡️ Installation

```bash
composer install
```


## Getting Started

To start the application, you should first make sure that your PHP environment is properly configured (PHP 8.x or later recommended) and your database connection settings are defined.

Unlike Laravel's built-in server, this framework is intended to be run with a web server like **Apache**, **Nginx**, or **Caddy**. Simply point your web server’s document root to the `public` directory of the project.

Basic steps to get it running:

1. Clone the repository:

    ```bash
    git clone https://github.com/HosseinMasumpoor/NovaAPI
    cd NovaAPI
    ```

2. Install dependencies via Composer:

    ```bash
    composer install
    ```

3. Configure your `.env` file (database, cache, etc.).

4. Configure your web server (e.g., with Apache’s `DocumentRoot` set to `public/`).

5. Visit your app’s URL in the browser and you’re ready to go!


## Configuration

All configuration files are located in the `config` directory. You can easily extend and override default settings as needed. The configuration system also supports caching to ensure high performance in production environments.

## Extending

You can extend the framework by creating new service providers, facades, middlewares, or even replacing core components. The flexible architecture allows you to register your custom components within the service container and hook them into the framework lifecycle.

## Authentication

The framework includes a flexible authentication system that supports different drivers, such as JWT and OTP. You can easily add new drivers by implementing the `GuardInterface` or extending the existing driver implementation.

## License

This project is open-sourced under the MIT license.

## Author

**Hossein Masumpoor**
