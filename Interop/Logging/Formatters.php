<?php

namespace Electro\Interop\Logging;

use Electro\Interop\Registry;
use Monolog\Formatter\FormatterInterface;

/**
 * @method null|FormatterInterface get(string $name) Gets the log formatter registered with the specified name.
 */
class Formatters extends Registry
{
}
