<?php
namespace Selenia\Interfaces\Http\Shared;

use Selenia\Interfaces\Http\RouterInterface;

/**
 * Represents the application's main/root HTTP request router.
 *
 * <p>The router runs a sub-pipeline of the application's middleware pipeline, which is comprised of routables (route
 * maps or request handlers).
 * <p>Application modules can add their routables to this sub-pipeline by injecting the shared instance of this
 * interface and using its API.
 *
 * ###### Example:
 * > ```
 * class MyModule
 * {
 *   function configure (RootRouterInterface $router)
 *   {
 *     $myRoutesOrRouterOrMiddleware = ...
 *     $router->add ($myRoutesOrRouterOrMiddleware);
 *   }
 * }
 * > ```
 */
interface ApplicationRouterInterface extends RouterInterface
{
}
