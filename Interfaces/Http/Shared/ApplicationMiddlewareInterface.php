<?php
namespace Electro\Interfaces\Http\Shared;

use Electro\Interfaces\Http\MiddlewareStackInterface;

/**
 * Represents the application's main/root HTTP middleware stack.
 *
 * <p>Application modules can add their middleware to this stack by injecting the shared instance of this interface
 * and using its API.
 *
 * ###### Example:
 * > ```
 * class MyModule
 * {
 *   function configure (ApplicationMiddlewareInterface $stack)
 *   {
 *     $stack->add ([...]);
 *   }
 * }
 * > ```
 */
interface ApplicationMiddlewareInterface extends MiddlewareStackInterface
{
}
