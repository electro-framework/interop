<?php
namespace Electro\Interfaces;

/**
 * A class that implements the event emitter pattern, which is a variation of the publish/subscribe pattern.
 *
 * <p>Unlike a typical pub/sub system, only the emitter can publish its events to its subscribers, so the later are
 * coupled to the former.
 *
 * <p>This interface only exposes the functionality required for emiting events.
 * If the class also exposes event listener registration, it should implement also the
 * {@see \Electro\Interfaces\EventSubscriberInterface}.
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
