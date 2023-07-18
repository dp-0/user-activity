# UserActivity

User Activity is a Laravel package that allows you to effortlessly track user activity within your Laravel application. It provides a convenient way to log various user actions, including login, logout, page visits, and custom events.

## Features

- Log user login, Lockout and logout events.
- Track page visits and user interactions.
- Custom event logging to monitor specific user activities.
- Easily configurable to include or exclude specific actions from tracking.


## Installation

To install the User Activity package

```bash
composer require dp-0/user-activity
```


```bash
php artisan user-activity:install
```
## Configuration
After installing the package, it automatically publishes the configuration file for customizing the tracking behavior. You can modify the `user-activity.php` config file as needed.

## Usage

```php
use Dp0\UserActivity\Traits\UserActivity;
```
Then, add the trait to your model:
```php
class YourModel extends Model
{
    use UserActivity;

    // Your model code here
}
```
## Documentation

For detailed documentation  references, please read [Article](https://medium.com/@dineshphuyel20/enhance-user-tracking-in-laravel-with-the-user-activity-package-a-comprehensive-guide-683050f88a98).

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.
