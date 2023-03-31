# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wdev-rs/laravel-analytics.svg?style=flat-square)](https://packagist.org/packages/wdev-rs/laravel-analytics)
[![Total Downloads](https://img.shields.io/packagist/dt/wdev-rs/laravel-analytics.svg?style=flat-square)](https://packagist.org/packages/wdev-rs/laravel-analytics)
![GitHub Actions](https://github.com/wdev-rs/laravel-analytics/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require wdev-rs/laravel-analytics
```

Install the vue-chartjs integration

```bash
npm install vue-chartjs@^4.0.0 chart.js
```

Publish the vendor files by running

```bash
php artisan vendor:publish --provider="WdevRs\LaravelAnalytics\LaravelAnalyticsServiceProvider"
```

## Usage

Add alias to middleware in `app/Http/Kernel.php`
```php
    protected $routeMiddleware = [
        ...
        'analytics' => \WdevRs\LaravelAnalytics\Http\Middleware\Analytics::class,
        ...
    ];        
```

Add the `analytics` middleware to the routes you'd like to track

```php

Route::middleware(['analytics'])->group(function () {
    Route::get('/', [PagesController::class,'index'])->name('pages.home');
});

```

### Admin

Register the vue components to display analytics

```js
Vue.component('page-views-per-days', require('./vendor/laravel-analytics/components/PageViewsPerDays.vue').default);
Vue.component('page-views-per-paths', require('./vendor/laravel-analytics/components/PageViewsPerPaths.vue').default);
```

Use the components in your dashboard or where you like :) 

Pass the data from controller

```php
        $pageViewRepository = app(PageViewRepository::class);
        $pageViewsPerDays = $pageViewRepository->getByDateGroupedByDays(Carbon::today()->subDays(28));
        $pageViewsPerPaths = $pageViewRepository->getByDateGroupedByPath(Carbon::today()->subDays(28));

        return view('admin.dashboard.index',
            [
                'pageViewsPerDays' => $pageViewsPerDays,
                'pageViewsPerPaths' => $pageViewsPerPaths
            ]);
```

```php
<page-views-per-days :initial-data="{{json_encode($pageViewsPerDays)}}"/>
<page-views-per-paths :initial-data="{{json_encode($pageViewsPerPaths)}}"/>
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email daniel@wdev.rs instead of using the issue tracker.

## Credits

-   [Daniel Werner](https://github.com/wdev-rs)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
