Tekton Support
==============

The support project is a collection of utility functions and classes/traits that can be reused in other projects. It includes a couple of helper functions and classes that simplifies data manipulation and management.

## Installation

```sh
composer require tekton/support
```

## Usage

By default the project also includes a select set of utilities from `illuminate/support` without pulling in all of the Laravel specific code. The version included is currently 5.4 (Collection, Fluent, helpers, etc.) and it's only included if it's not loaded from elsewhere. So the version can easily be overridden by depending on a specific version in your own project.

If you'd rather not load any of the Illuminate components you can set the constant `TEKTON_ILLUMINATE` to false before including the autoload file.

```php
define('TEKTON_ILLUMINATE', false);

require "vendor/autoload.php";
```

## License

MIT
