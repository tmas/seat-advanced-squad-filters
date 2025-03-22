# My SeAT Plugin

A plugin for [SeAT](https://github.com/eveseat/seat) that provides additional functionality.

## Installation

You can install this package via composer:

```bash
composer require yourvendor/seat-myplugin
```

Then, publish the assets and run migrations:

```bash
php artisan vendor:publish --force --provider="YourVendor\YourPackage\MyPluginServiceProvider"
php artisan migrate
```

## Configuration

Configure your plugin settings at http://seat.your-domain/myplugin

## License

This package is licensed under the MIT license. 