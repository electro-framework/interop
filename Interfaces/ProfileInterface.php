<?php
namespace Electro\Interfaces;

/**
 * A configuration profile.
 */
interface ProfileInterface
{
  /**
   * @return string The class name of the framework bootloader to be used when booting up with this profile.
   */
  static public function getBootloaderClass ();

  /**
   * @return string[] A list of module names, of any module type.
   */
  public function getExcludedModules ();

  /**
   * @return string The profile's name, which is used to generate a file path for the framework-generated cached
   *                bootloader file for the profile.
   */
  public function getName ();

  /**
   * @return string[] A list of subsystem module names.
   */
  public function getSubsystems ();

}
