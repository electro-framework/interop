<?php

namespace Electro\Interfaces;

/**
 * A class that implements the event subscriber pattern.
 *
 * <p>This interface only exposes the functionality required for registering event listeners.
 * <p>If the class also exposes event emitting, it should also implement {@see EventEmitterInterface}.
 *
 * ><p>**Note:** sometimes an event emitter class may need to implement the `emit` method as a protected or private
 * method to prevent other classes to emit its events. That's the reason for splitting this pattern into two interfaces.
 *
 * @see EventsTrait
 */
interface EventSubscriberInterface
{
  /**
   * Registers an event listener.
   *
   * @param string   $event    The event name.
   * @param callable $listener A callback function (...$eventArgs).
   * @return $this Self, for chaining.
   */
  function on ($event, callable $listener);

}
