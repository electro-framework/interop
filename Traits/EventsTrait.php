<?php
namespace Electro\Traits;

/**
 * Implements the event emitter/listener pattern (a variation of the publish/subscribe pattern).
 *
 * <p>A class using this trait is able to emmit events to a set of listeners that have subscribed to those events.
 * <p>Unlike a typical pub/sub system, only the emitter can publish its events to its subscribers, so the later are
 * coupled to the former.
 *
 * <p>A class using this trait may implement {@see EventSubscriberInterface} and/or {@see EventEmitterInterface} if
 * you want to make the corresponding methods public.
 *
 * <p>To make one or both of these methods public, use the following syntax:
 * ```
 * use EventsTrait { emit as public; on as public; }
 * ```
 */
trait EventsTrait
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
  protected function on ($event, callable $listener)
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
