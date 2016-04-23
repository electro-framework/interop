<?php
namespace Selenia\Interfaces\DI;

use Interop\Container\ContainerInterface;
use Selenia\Interfaces\MapInterface;

/**
 * The service container is a directory service that maps abstract service names (ex: 'app') to concrete
 * implementations.
 *
 * <p>Unlike a simple {@see Map}, the container registers class or interface names when written to, but it returns class
 * instances when read.
 *
 * <p>To read the original string value for a key, call {@see getRaw()}.
 */
interface ServiceContainerInterface extends MapInterface, ContainerInterface
{
  /**
   * Retrieves the original string value that was set for a given key.
   *
   * @param string $key
   * @return string
   */
  public function getRaw ($key);
}
