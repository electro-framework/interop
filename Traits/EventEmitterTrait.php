<?php
namespace Electro\Traits;

/**
 * Implements the event emitter pattern, which is a variation of the publish/subscribe pattern.
 *
 * <p>A class using this trait is able to emmit events to a set of listeners that have subscribed to those events.
 * <p>Unlike a typical pub/sub system, only the emitter can publish its events to its subscribers, so the later are
 * coupled to the former.
 *
 * <p>A class using this trait should implement the {@see \Electro\Interfaces\EventSubscriberInterface}.
 */
trait EventEmitterTrait
{
  /**
   * @var callable[][]
   */
  private $listeners = [];

  /**
   * Registers an event listener.
   *
   * @param string   $event   The event name.
   * @param callable $listener A callback function (...$eventArgs).
   * @return $this For chaining.
   */
  function on ($event, callable $listener)
  {
    $this->listeners[$event][] = $listener;
    return $this;
  }

  /**
   * Emits an event to all listener registered for that event (if any).
   *
   * <p>This method is protected, as events should only be emitted by the emitter and no one else.
   *
   * @param string $event   The event name.
   * @param mixed  ...$args The arguments sent to each listener callback.
   */
  protected function emit ($event, ...$args)
  {
    foreach (get ($this->listeners, $event, []) as $l)
      $l (...$args);
  }

}
