<?php
namespace Electro\Interfaces;

/**
 * A configuration profile that defines how the application boots up and which subsystems and modules are loaded.
 *
 * <p>Profiles typify certain types of applications, ex: a web application, a console application, a micro-framework
 * based web service, etc.
 */
interface ProfileInterface
{
  /**
   * @return string The class name of the framework bootloader to use when booting up with this profile.
   */
  public function getBootloaderClass ();

  /**
   * Returns a blacklist of names of modules that must not be loaded.
   *
   * <p>Exclusions from this list take precedence over whitelisted modules.
   *
   * @see getIncludedModules
   * @return string[]
   */
  public function getExcludedModules ();

  /**
   * Returns a whitelist of names of modules that will always be loaded, even if they state that they are not compatible
   * with this profile.
   *
   * @see getExcludedModules
   * @return string[]
   */
  public function getIncludedModules ();

  /**
   * @return string The injector instance to use on the framework when using this profile.
   */
  public function getInjector ();

  /**
   * @return string The class name of the kernel to use when booting up with this profile.
   */
  public function getKernelClass ();

  /**
   * @return string The profile's name, which is used to generate a file path for the framework-generated cached
   *                bootloader file for the profile.
   */
  public function getName ();

}
