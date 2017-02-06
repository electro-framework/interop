<?php

namespace Electro\Interop\Logging;

use Electro\Interop\Registry;
use Monolog\Logger;

/**
 * @method null|Logger get(string $name) Gets the logger registered with the specified name.
 */
class Loggers extends Registry
{
}
