<?php
namespace Selenia\Interfaces\DI;

use Interop\Container\ContainerInterface;

/**
 * The service container is a directory service that maps abstract service names (ex: 'app') to concrete
 * implementations.
 */
interface ServiceContainerInterface extends \MapInterface, ContainerInterface
{
  /**
   * Fetches a service by name from the service container.
   *
   * @param string $alias A service short alias name.
   * @return mixed The corresponding service instance.
   */
  public function get ($alias);
}
