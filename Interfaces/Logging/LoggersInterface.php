<?php

namespace Electro\Interfaces\Logging;

use Electro\Logging\Services\Loggers;
use Psr\Log\LoggerInterface;


/**
 * Allows the creation, storage and retrieval of named logger instances.
 */
interface LoggersInterface
{
  /**
   * Creates and registers a logger with a specific name.
   *
   * @param string $name The name to associated with the logger.
   * @return LoggerInterface $logger The new logger instance.
   */
  function make ($name);

  /**
   * Retrieves a logger instance by name.
   *
   * <p>If no logger is registered with the given name, a {@see NullLogger} is returned.
   *
   * @param string $name The registered logger name.
   * @return LoggerInterface
   */
  function get ($name);

  /**
   * Checks if a logger with the given name is registered.
   *
   * @param string $name The registered logger name.
   * @return bool
   */
  function has ($name);

  /**
   * Registers a logger with a specific name.
   *
   * @param string          $name   The name to associated with the logger.
   * @param LoggerInterface $logger The logger instance to be shared.
   * @return $this
   */
  function register ($name, LoggerInterface $logger);

  /**
   * Removes a logger instance by name, if one exists.
   *
   * @param string $name The registered logger name.
   * @return $this
   */
  function unregister ($name);
}
