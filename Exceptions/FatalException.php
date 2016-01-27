<?php
namespace Selenia\Exceptions;

use Selenia\Exceptions;

/**
 * An exception that should not be handled/intercepted by application-level code.
 * Instead, it should halt execution and display a message to the user.
 */
class FatalException extends \Exception
{
}
