<?php
namespace Electro\Traits;

/**
 * Implements the observer pattern.
 */
trait ObserverTrait
{
  /**
   * @var callable[][]
   */
  private $observers = [];

  /**
   * Emits an event to all handlers registered to that event (if any).
   *
   * @param string $event   The event name.
   * @param mixed  ...$args The arguments sent to each handler callback.
   */
  function emit ($event, ...$args)
  {
    foreach (get ($this->observers, $event, []) as $l)
      $l (...$args);
  }

  /**
   * Registers an event handler.
   *
   * @param string   $event   The event name.
   * @param callable $handler A callback function (...$eventArgs).
   */
  function on ($event, callable $handler)
  {
    $this->observers[$event][] = $handler;
  }

}
