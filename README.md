<img src="https://banners.beyondco.de/Devices.png?theme=light&packageManager=composer+require&packageName=sfolador%2Fdevices&pattern=architect&style=style_1&description=Manage+devices+and+device+tokens+&md=1&showWatermark=1&fontSize=100px&images=upload">


# Manage mobile devices and tokens easily with Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfolador/devices.svg?style=flat-square)](https://packagist.org/packages/sfolador/devices)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sfolador/devices/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sfolador/devices/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sfolador/devices/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sfolador/devices/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sfolador/devices.svg?style=flat-square)](https://packagist.org/packages/sfolador/devices)

Easily manage devices and device tokens for your users.



## Installation

You can install the package via composer:

```bash
composer require sfolador/devices
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="devices-config"
```
This is the contents of the published config file:

```php
return [
     'allow_device_reassign' => false,
];
```

if you set `allow_device_reassign` to true, it will be possible to 
register a device for a user and then assign it to another user. This happens usually 
in mobile applications with multi-accounts on the same device.


You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="devices-migrations"
php artisan migrate
```

the migration will create the `Devices` table and its columns will be:

- `id` - the device id
- `notifiable_id` - the "user" id
- `notifiable_type` - the "user" type
- `name` - the device name
- `type` - the device type (mobile, web)
- `platform` - the device platform (ios, android, web)
- `token` - the device token
- `created_at` - the device creation date
- `updated_at` - the device update date

It's possible to use the `HasDevices` trait in your `User` model:

```php
use Sfolador\Devices\Models\Concerns\HasDevices;

class User extends Authenticatable
{
    use HasDevices;
}
```

At this point is possible to retrieve the devices of a user:

```php
$user = User::find(1);
$user->devices;
```

To register a new `Device`, for example from a mobil app, you can use the provided route `POST /devices/attach`:

```php
Route::post('/devices/attach', [DeviceController::class, 'attach']);
```




## Usage





## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [sfolador](https://github.com/sfolador)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
