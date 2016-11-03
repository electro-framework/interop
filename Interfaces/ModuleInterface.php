<?php
namespace Electro\Interfaces;

use Electro\Kernel\Lib\ModuleInfo;

/**
 * Marks a class as being able to provide configuration and initialization for the module it belongs to.
 */
interface ModuleInterface
{
  /**
   * Starts up the module.
   *
   * <p>Use this method to perform module initialization during the framework's start up process.
   *
   * @param KernelInterface $kernel     The kernel service. It allows the module to listen to one or more kernel
   *                                    events.
   * @param ModuleInfo      $moduleInfo Information about the module being loaded.
   * @return
   */
  static function startUp (KernelInterface $kernel, ModuleInfo $moduleInfo);
}
