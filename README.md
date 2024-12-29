# FilamentPHP Billing System

An example project demonstrating a billing system built with Laravel and FilamentPHP. It includes subscription management, recurring payments, and integration with Stripe using Laravel Cashier. The system also features a FilamentPHP interface for managing plans and viewing billing details.

![Screenshot of Application Feature](./public/images/screenshot.png)

## Prerequisites

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 16.0
- MySQL >= 8.0 or SQLite >= 3.0
- Laravel >= 11.x

## Installation

1. Clone the repository
```bash
git clone git@github.com:Willy-Bueno/filament-billing-example.git
cd filament-billing-example
```

2. Install PHP dependencies
```bash
composer install
```

3. Install and compile frontend dependencies
```bash
npm install
npm run dev
```

4. Configure environment variables
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=billing_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

7. Link storage for file uploads
```bash
php artisan storage:link
```

8. Create a Filament user
```bash
php artisan make:filament-user
```

9. Configure Stripe keys in `.env`
```
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
```

10. Configure the stripe prices in the `config/stripe.php` file

## Contributing

1. Fork the repository
2. Create your feature changes in your branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## Security

If you discover any security-related issues, please email willybueno090@gmail.com instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Credits

- [Willy-Bueno](https://github.com/Willy-Bueno)
- [All Contributors](../../contributors)

## Support

For support, please email willybueno090@gmail.com or create an issue in the GitHub repository.
