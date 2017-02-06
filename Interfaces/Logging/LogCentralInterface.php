<?php

namespace Electro\Interfaces\Logging;

use Electro\Interop\Logging\Formatters;
use Electro\Interop\Logging\Handlers;
use Electro\Interop\Logging\Loggers;
use Electro\Interop\Logging\Processors;
use Monolog\Handler\HandlerInterface;

const LOG_GENERAL = 'general';

/**
 * Allows the creation, storage and retrieval of logger channels, processors, handlers and formatters; and configuring
 * the wiring bewteen those elements.
 */
interface LogCentralInterface
{
  /**
   * Assigns formatters to handlers.
   *
   * <p>The argument may be:
   * - a map of `['formatter name' => 'handler name']`
   * - a map of `['formatter name' => ['handler 1', 'handler 2', ...]]`
   *
   * @param string[]|array[] $map
   * @return $this
   */
  function assignFormattersToHandlers (array $map);

  /**
   * Connects handlers to processors.
   *
   * <p>The argument may be:
   * - a map of `['logger name' => 'processor name']`
   * - a map of `['logger name' => ['processor 1', 'processor 2', ...]]`
   *
   * @param string[]|array[] $map
   * @return $this
   */
  public function connectHandlersToProcessors (array $map);

  /**
   * Connects loggers to handlers.
   *
   * <p>The argument may be:
   * - a map of `['logger name' => 'handler name']`
   * - a map of `['logger name' => ['handler 1', 'handler 2', ...]]`
   *
   * @param string[]|array[] $map
   * @return $this
   */
  function connectLoggersToHandlers (array $map);

  /**
   * Connects loggers to processors.
   *
   * <p>The argument may be:
   * - a map of `['logger name' => 'processor name']`
   * - a map of `['logger name' => ['processor 1', 'processor 2', ...]]`
   *
   * @param string[]|array[] $map
   * @return $this
   */
  function connectLoggersToProcessors (array $map);

  /**
   * Gets the log formatter registry,
   *
   * @return Formatters
   */
  function formatters ();

  /**
   * Returns either a handler registered with the given name or, if it's not registered yet, a proxy for the future
   * handler.
   *
   * <p>Use this when building handlers that need to receive references to other handlers at instantiation time and you
   * want to use a handler registration name instead of a direct reference to it.
   *
   * @param string $name A registration handler name.
   * @return HandlerInterface
   */
  function handler ($name);

  /**
   * Creates a handler that groups other handlers.
   *
   * ><p>**Note:** handlers can belong to multiple groups.
   *
   * @param string[] ...$names The registration names of the handlers that belong to the group.
   * @return HandlerInterface
   */
  function handlerGroup (...$names);

  /**
   * Gets the log handler registry,
   *
   * @return Handlers
   */
  function handlers ();

  /**
   * Gets the loggers registry,
   *
   * @return Loggers
   */
  function loggers ();

  /**
   * Gets the log processor registry,
   *
   * @return Processors
   */
  function processors ();

}
