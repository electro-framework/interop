<?php
namespace Electro\Interfaces;

use Electro\Core\Assembly\Services\Bootstrapper;

/**
 * Marks a class as being able to provide configuration and bootstrapping for the module it belongs to.
 */
interface ModuleInterface
{
  /**
   * Allows a module to perform its initialization during the framework's bootstrap process.
   *
   * <p>The provided argument is a bootstrapper service that allows the module to listen to one or more bootstrap
   * events.
   *
   * @param Bootstrapper $boot The bootstrapper service.
   * @return void
   */
  static function boot (Bootstrapper $boot);
}
