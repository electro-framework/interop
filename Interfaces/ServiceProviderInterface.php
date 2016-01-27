<?php
namespace Selenia\Interfaces;

/**
 * Indicates to the framework that a class can perform service registrations.
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
