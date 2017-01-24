<?php

namespace Electro\Interfaces;

/**
 * A class that implements the event emitter pattern.
 *
 * <p>This interface only exposes the functionality required for emitting events.
 * <p>If the class also exposes event listener registration, it should also implement
 * {@see \Electro\Interfaces\EventSubscriberInterface}.
 *
 * ><p>**Note:** sometimes an event emitter class may need to implement the `emit` method as a protected or private
 * method to prevent other classes to emit its events. That's the reason for splitting this pattern into two interfaces.
 *
 * @see EventBroadcasterTrait
 */
interface EventEmitterInterface
{
  /**
   * Emits an event to all listeners registered for that event (if any).
   *
   * @param string $event   The event name.
   * @param mixed  ...$args The arguments sent to each listener callback.
   */
  function emit ($event, ...$args);

}
