<h1 id="top" align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="./docs/media/artex-agency-logo-dark.png">
        <img width="54" alt="Artex Agency Logo" src="./docs/media/artex-agency-logo.png">
    </picture>    
    <br>
    <strong>LOGGER</strong>
    <sup>
        <br>
        <small><small><small>
        FAST PSR-3 LOGGER
        </small></small></small>
    </sup>
</h1>

**Artex Logger** is a lightweight, high-performance PHP logging library that adheres to **PSR-3 standards**, making it highly compatible with existing frameworks. It provides structured logging, supports log rotation, and offers optional asynchronous logging to ensure minimal performance impact.

&nbsp;

## Key Features
- **Lightweight & High-Performance**: Minimal overhead, designed for speed.
- **PSR-3 Compliant**: Fully compatible with existing logging frameworks.
- **Structured Logging**: Supports JSON and customizable log formats.
- **Log Rotation**: Prevents uncontrolled growth of log files.
- **Asynchronous Logging**: Optional non-blocking log writing.

&nbsp;

---

&nbsp;

## Installation

```sh
composer "require artex/exceptions"
```

&nbsp;

## Usage

### Basic Example

```php
use Artex\Exceptions\ArtexRuntimeException;

try {
    throw new ArtexRuntimeException("Something went wrong!", 500);
} catch (ArtexRuntimeException $e) {
    echo $e->getMessage();
}
```

### Adding Context to Exceptions

```php
use Artex\Exceptions\ArtexException;

try {
    throw new ArtexException(
        "Validation failed!",
        422,
        ['field' => 'email', 'error' => 'Invalid format']
    );
} catch (ArtexException $e) {
    // Access additional context
    var_dump($e->getContext());
}
```

### Extending Exceptions

You can easily extend any Artex exception to create project-specific exceptions:

```php
namespace MyApp\Exceptions;

use Artex\Exceptions\ArtexRuntimeException;

class CustomException extends ArtexRuntimeException
{
    public function __construct(string $message = "", int $code = 0, array $context = [])
    {
        parent::__construct($message, $code, $context);
    }
}
```

### Logging Exceptions

The library can seamlessly log exceptions if a PSR-3 compatible logger is available:

```php
use Artex\Exceptions\ArtexRuntimeException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Set up a PSR-3 logger
$logger = new Logger('example');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

// Register the logger
ArtexRuntimeException::registerLogger($logger);

try {
    throw new ArtexRuntimeException("Critical failure", 500);
} catch (ArtexRuntimeException $e) {
    // Exception is automatically logged
    echo "Exception logged: " . $e->getMessage();
}
```

---

&nbsp;

## Available Exceptions

The library ships with the following prebuilt exceptions:

| Exception Class                 | Description                                  |
|---------------------------------|----------------------------------------------|
| `ArtexException`                | Base exception class for all custom exceptions. |
| `ArtexRuntimeException`         | For runtime errors.                          |
| `ArtexInvalidArgumentException` | For invalid arguments passed to functions.   |
| `ArtexLogicException`           | For logical errors in the application.       |
| `ArtexUnexpectedValueException` | For unexpected values in operations.         |
| `ValidationException`           | For validation-specific errors.              |
| `DatabaseException`             | For database-related errors.                 |
| `FileException`                 | For file-related errors.                     |

---

&nbsp;

## Advanced Usage

### Extending Exceptions

You can easily extend any Artex exception to create project-specific exceptions:

```php
namespace MyApp\Exceptions;

use Artex\Exceptions\ArtexRuntimeException;

class CustomException extends ArtexRuntimeException
{
    public function __construct(string $message = "", int $code = 0, array $context = [])
    {
        parent::__construct($message, $code, $context);
    }
}
```
&nbsp;
## Requirements

- PHP 8.0 or higher


&nbsp;

--- 

&nbsp;

## Contributing

We welcome contributions to the Artex Standard Exceptions Library! If you have an idea, feature request, or find a bug, please open an issue or submit a pull request.

&nbsp;

## LICENSE
This software is distributed under the **Apache 2.0** License, granting you the freedom to use, modify, and distribute the software, provided you adhere to the terms outlined in the license.

See the [LICENSE](./LICENSE) file for details.

&nbsp;

<div align="center">
    <h2>FOLLOW US</h2>
    <a href="https://x.com/artexagency" title="Follow Artex Agency on X/Twitter"><img src="./docs/media/social/x.svg" width="18" height="18" alt="X/Twitter"></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="https://github.com/artex-agency" title="Check out Artex Agency on GitHub"><img src="./docs/media/social/github.svg" width="23" height="23" alt="GitHub"></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="https://www.linkedin.com/company/artexagency" title="Connect with Artex Agency on LinkedIn"><img src="./docs/media/social/linkedin.svg" width="23" height="23" alt="LinkedIn"></a>
</div>


&nbsp;

<div align="center">
    <h2></h2>
    <sup>
        COPYRIGHT <small>&copy;</small> 2025 <strong>ARTEX AGENCY INC.</strong>
    </sup>
</div>