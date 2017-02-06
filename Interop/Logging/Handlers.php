<?php

namespace Electro\Interop\Logging;

use Electro\Interop\Registry;
use Monolog\Handler\HandlerInterface;

/**
 * @method null|HandlerInterface get(string $name) Gets the log handler registered with the specified name.
 */
class Handlers extends Registry
{
}
