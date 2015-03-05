# foundation-pagination

This Laravel 5 package provides a `FoundationPresenter` class for generating
Foundation-themed pagination in your applications.

This will probably not work with Laravel 4. For the Laravel 4 version see the 
original project: https://github.com/binarix/Laravel-Foundation-Pagination

## Installation

This release v2.0.0 supports the following (stable) versions of Laravel:
        "laravel/framework": "5.0.*"

Begin by installing this package through Composer. Edit your project's 
`composer.json` file to require `eduard44/foundation-pagination`:

```json
    "require": {
        "eduard44/foundation-pagination": "2.0.*"
    }
```

Next, update Composer from the Terminal:

    composer update

## Usage

Since Laravel 5.0.7, we can replace the built-in bootstrap presenter this way:

```
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
