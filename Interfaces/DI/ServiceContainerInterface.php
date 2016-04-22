<?php
namespace Selenia\Interfaces\DI;

use Interop\Container\ContainerInterface;
use Selenia\Interfaces\MapInterface;

/**
 * The service container is a directory service that maps abstract service names (ex: 'app') to concrete
 * implementations.
 */
interface ServiceContainerInterface extends MapInterface, ContainerInterface
{
}
