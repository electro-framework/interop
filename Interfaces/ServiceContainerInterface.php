<?php
namespace Selenia\Core\DependencyInjection;

/**
 * Allows you to define short service alias names that map to fuly qualified injectable class names.
 * The corresponding services can then be read from the injector indirectly via this container.
 *
 * ><p>**Note:** a service container is an antipattern in most situations. On Selenia, it is reserved for a few very
 * specific use cases.
 * >><p>For ex. see the {@see Use_} component class.
 */
interface ServiceContainerInterface extends \MapInterface
{
  /**
   * Fetches a service by name from the service container.
   *
   * @param string $alias A service short alias name.
   * @return mixed The corresponding service instance.
   */
  public function get ($alias);
}
