<?php
namespace Electro\Interfaces;

use Electro\Kernel\Lib\ModuleInfo;

/**
 * Marks a class as being able to provide configuration and initialization for the module it belongs to.
 */
interface ModuleInterface
{
  /**
   * Defines which configuration profiles this module is compatible with.
   *
   * <p>if the current profile is one of the listed profiles or it's a subclass of one of them, the module is loaded,
   * otherwise it's not.
   *
   * @return string[] A list of names of classes that implement ProfileInterface.
   */
  static function getCompatibleProfiles ();

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
