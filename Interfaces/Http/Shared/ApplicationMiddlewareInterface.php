<?php
namespace Selenia\Interfaces\Http\Shared;

use Selenia\Interfaces\Http\MiddlewareStackInterface;

/**
 * Represents the application's main/root HTTP middleware stack.
 *
 * <p>Application modules can add their middlewares to this stack by injecting the shared instance of this interface
 * and using its API.
 *
 * ###### Example:
 * > ```
 * class MyModule
 * {
 *   function configure (RootMiddlewareStackInterface $stack)
 *   {
 *     $myMiddleware = ...
 *     $stack->add ($myMiddleware);
 *   }
 * }
 * > ```
 */
interface ApplicationMiddlewareInterface extends MiddlewareStackInterface
{
}
