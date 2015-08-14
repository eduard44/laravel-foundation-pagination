# foundation-pagination

This Laravel 5 package provides a `FoundationPresenter` class for generating
Foundation-themed pagination in your applications.

This will probably not work with Laravel 4. For the Laravel 4 version see the
original project: https://github.com/binarix/Laravel-Foundation-Pagination

## Changes

**v3.0.0**: Mainly cleaning up the code in general: Instead of relying on things
 like string concatenation or `sprintf`, the library now uses
 `etcinit/nucleus`'s view component, which takes care of properly escaping the
 HTML output of the paginator when needed.

Additionally, a `SimpleFoundationPresenter` class is now available. It performs
the same function as it's Bootstrap counterpart in Laravel

**v2.0.0**: Adds support for Laravel 5.

## Installation

> WARNING: Version v3.0.0 hasn't been released yet. The instructions below might not work properly. For a stable release, please use [v2.0.0](https://github.com/etcinit/laravel-foundation-pagination/tree/2.0.0).

The current release (v3.0.0) supports the following versions of
Laravel, Lumen and Illuminated:

```json
    "laravel/framework": "~5.0",
    "laravel/framework": "~5.1",
    "lumen/framework": "~5.0",
    "lumen/framework": "~5.1",
    "chromabits/illuminated": "dev-master",
```

To include in in your project, simple use `composer`:

```sh
$ cd /path/to/project
$ composer require chromabits/foundation-pagination
```

## Usage

Since Laravel 5.0.7, we can replace the built-in bootstrap presenter this way:

```php
use Chromabits\Pagination\FoundationPresenter;

// To be set in a service provider or wherever
Paginator::presenter(function($paginator)
{
    return new FoundationPresenter($paginator);
});
```

If you wish to replace it manually, you have to instantiate the presenter every time you wish to render pagination:

```php
use App\Models\Post;
use Chromabits\Pagination\FoundationPresenter;

$paginator = Post::query()->paginate();

$html = $paginator->render(new FoundationPresenter($paginator));
```

For more information on Pagination with Laravel 5, please check out the docs at
http://laravel.com/docs/pagination
