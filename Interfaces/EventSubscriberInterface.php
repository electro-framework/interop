<?php
namespace Electro\Interfaces;

/**
 * A class that implements the event emitter pattern, which is a variation of the publish/subscribe pattern.
 *
 * <p>Unlike a typical pub/sub system, only the emitter can publish its events to its subscribers, so the later are
 * coupled to the former.
 *
 * <p>This interface only exposes the functionality required for registering event listeners.
 * If the class also exposes event emitting, it should implement also the
 * {@see \Electro\Interfaces\EventEmitterInterface}.
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
