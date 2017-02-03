<?php

namespace Electro\Interfaces\Logging;

use Monolog\Logger;

/**
 * A class responsible for creating and configuring the application's main Monolog logger.
 *
 * This interface allows the application to override the framework's predefined logging configuration.
 */
interface MainLoggerFactoryInterface
{
  /**
   * Creates and configures the application's main logger.
   *
   * <p>The logger MUST be named `main`.
   *
   * <p>This method may add *formatters*, *handlers* and *processors* to it.
   *
   * @return Logger The new logger instance.
   */
  function make ();

}
