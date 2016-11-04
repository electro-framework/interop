<?php
namespace Electro\Interfaces;

use Electro\Interfaces\DI\InjectorInterface;

/**
 * A 2nd level application launcher class with a booting sequence that is customized for a specific kind of
 * application; for ex: a web application or a console application.
 *
 * It is invoked by the 1st level bootloader, which is applicable to all types of applications.
 */
interface BootloaderInterface
{
  /**
   * @param InjectorInterface $injector Provide your favorite dependency injector, eventually with some
   *                                    pre-registered services to override some of the core framework services.
   */
  function __construct (InjectorInterface $injector);

  /**
   * Bootstraps the application
   *
   * @param string   $rootDir   The application's root directory path.
   * @param int      $urlDepth  How many URL segments should be stripped when calculating the application's root URL.
   *                            Use it when booting a sub-application from an index.php on a sub-directory of the main
   *                            application.
   * @param callable $onStartUp If specified, the callback will be invoked right before the kernel boots up. It will be
   *                            given the kernel instance as an argument, so that you can use this to register listeners
   *                            for kernel events, similar to what {@see ModuleInterface::startUp} does for modules.
   * @return int Exit status code. Only meaningful for console applications.
   */
  function boot ($rootDir, $urlDepth = 0, callable $onStartUp = null);
}
