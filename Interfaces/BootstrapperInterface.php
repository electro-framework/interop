<?php
namespace Electro\Interfaces;

use Electro\Interfaces\DI\InjectorInterface;

/**
 * A class that bootstraps an Electro-based application.
 *
 * Its goal is to launch the framework and run the application.
 */
interface BootstrapperInterface
{
  /**
   * @param InjectorInterface $injector     Provide your favorite dependency injector.
   * @param string            $profileClass The configuration profile's fully qualified class name.
   */
  function __construct (InjectorInterface $injector, $profileClass);

  /**
   * Bootstraps the application.
   *
   * @param string $rootDir  The application's root directory path.
   * @param int    $urlDepth How many URL segments should be stripped when calculating the application's root URL.
   */
  function run ($rootDir, $urlDepth = 0);
}
