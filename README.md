# Laranotes

Internal note service for your Laravel application. This is not a "blog comment service".

## Installation and usage

This package requires PHP 7 and Laravel 5.6 or higher.

``` bash
php composer require binary-cats\laranote
```

Publish Migrations

``` bash
php artisan vendor:publish --provider=BinaryCats\\Laranote\\LaranoteServiceProvider --tag=migrations
```
Optionally, publish configuration
``` bash
php artisan vendor:publish --provider=BinaryCats\\Laranote\\LaranoteServiceProvider --tag=config
```

For any model that you want to have notes, import `BinaryCats\Laranote\HasManyNotes` as
```php

use BinaryCats\Laranote\HasManyNotes;

class User extends Model

    use HasManyNotes;

```
To get all notes, use the `notes()` method.

To add a new note:
```php
$user->note('This is a note content');
```
a note will be automatically added using currently logged in user. You may pass `true` as a second argument, to make the note private.

To add a new note using another user:
```php
$user = User::find(2);

$user->addNoteAsUser($user, 'This is a note content');
```
You may pass `true` as a third argument, to make this note private.


## Additional functionality

### ContextKey

In addition to `notes()` relation, HasManyNotes adds `makeContextKey()` that encrypts the model morph class and primary key. This value could be used as a owner key, if want to have a uniform note API service.

### Context macros in Request class

To utilize context key on the incoming side of application, `Illuminate\Http\Request` class is extended with three macros:
* `decryptContextKey()` - decrypt the string into array
* `makeContext()` - make a model instance out of decrypted key
* `resolveContext()` -> resolve the model instance from the DB.

## Development roadmap

* `resolveContext()` to include trashed models, if the model supports soft-deletes
* Deleting context should result in soft-deleting notes, configurable
* A bootstrap drop-in component
* A vuejs drop-in component
* Global scope of private notes

``` bash
composer test
```

## Testing

Run the tests with:

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email info@binarycats.io instead of using the issue tracker.

## Credits

- [Cyrill Kalita](https://bitbucket.org/cyrillkalita)
- [All Contributors](../../contributors)

## Support us
Binary Cats is a web service agency based in Roselle, Illinois.

Does your business depend on our contributions? Reach out!
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
