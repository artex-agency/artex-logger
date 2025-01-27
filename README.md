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

Artex Logger PSR-3 LOGGER is a simple, flexible PHP library that provides a simple, flexible way to log messages with contextual data. It adheres to the PSR-3 standards for logging, making it easy to integrate into existing logging frameworks and applications.

Artex Logger PSR-3 LOGGER is a PHP library that provides a simple, flexible way to log messages with contextual data. It adheres to the PSR-3 standards for logging, making it easy to integrate into existing logging frameworks and applications.


&nbsp;

## Key Features
- **Custom Exceptions**: Extendable exceptions for common use cases (e.g., runtime errors, validation errors, database errors).
- **PSR-4 Compliant**: Easy integration into modern PHP projects.
- **Contextual Data**: Include optional context information for better debugging.
- **Extensibility**: Provides a foundation to build project-specific exceptions.

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

<!--
##

<div align="center">
    <br>
    <h3>FOLLOW US</h3>
    <p>
        <a href="https://x.com/artexagency/" title="Artex Agency official x/twitter profile">
            <svg width="18" height="18" fill="none" viewBox="0 0 1200 1227" xmlns="http://www.w3.org/2000/svg">
            <path fill="#09F" d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z" /></svg></a>
        <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <a href="https://github.com/artex-agency" title="Artex Agency official GitHub profile and repository">
            <svg height="22" width="22" fill="none" aria-hidden="true" viewBox="0 0 24 24" data-view-component="true">
            <path fill="#09F" d="M12.5.75C6.146.75 1 5.896 1 12.25c0 5.089 3.292 9.387 7.863 10.91.575.101.79-.244.79-.546 0-.273-.014-1.178-.014-2.142-2.889.532-3.636-.704-3.866-1.35-.13-.331-.69-1.352-1.18-1.625-.402-.216-.977-.748-.014-.762.906-.014 1.553.834 1.769 1.179 1.035 1.74 2.688 1.25 3.349.948.1-.747.402-1.25.733-1.538-2.559-.287-5.232-1.279-5.232-5.678 0-1.25.445-2.285 1.178-3.09-.115-.288-.517-1.467.115-3.048 0 0 .963-.302 3.163 1.179.92-.259 1.897-.388 2.875-.388.977 0 1.955.13 2.875.388 2.2-1.495 3.162-1.179 3.162-1.179.633 1.581.23 2.76.115 3.048.733.805 1.179 1.825 1.179 3.09 0 4.413-2.688 5.39-5.247 5.678.417.36.776 1.05.776 2.128 0 1.538-.014 2.774-.014 3.162 0 .302.216.662.79.547C20.709 21.637 24 17.324 24 12.25 24 5.896 18.854.75 12.5.75Z"></path></svg></a>
        <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <a href="https://www.linkedin.com/company/artexagency" title="Artex Agency official LinkedIn profile">
        <svg height="21" width="21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310 310" xml:space="preserve">
            <path fill="#09F" d="M72.16,99.73H9.927c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5H72.16c2.762,0,5-2.238,5-5V104.73 C77.16,101.969,74.922,99.73,72.16,99.73z"/>
            <path fill="#09F" d="M41.066,0.341C18.422,0.341,0,18.743,0,41.362C0,63.991,18.422,82.4,41.066,82.4 c22.626,0,41.033-18.41,41.033-41.038C82.1,18.743,63.692,0.341,41.066,0.341z"/>
            <path fill="#09F" d="M230.454,94.761c-24.995,0-43.472,10.745-54.679,22.954V104.73c0-2.761-2.238-5-5-5h-59.599 c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5h62.097c2.762,0,5-2.238,5-5v-98.918c0-33.333,9.054-46.319,32.29-46.319 c25.306,0,27.317,20.818,27.317,48.034v97.204c0,2.762,2.238,5,5,5H305c2.762,0,5-2.238,5-5V194.995 C310,145.43,300.549,94.761,230.454,94.761z"/></svg></a>
    </p>
</div>
-->
<div align="center">
    <h2></h2>
    <sup>
        COPYRIGHT <small>&copy;</small> 2025 <strong>ARTEX AGENCY INC.</strong>
    </sup>
</div>