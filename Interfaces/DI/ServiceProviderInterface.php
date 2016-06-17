<?php
namespace Electro\Interfaces\DI;

/**
 * Declares that a class is able to perform service registrations.
 */
interface ServiceProviderInterface
{
  /**
   * Registers services on the provided dependency injector.
   * > **Best practice:** do not use the injector to fetch dependencies here.
   * @param InjectorInterface $injector
   */
  function register (InjectorInterface $injector);

}
