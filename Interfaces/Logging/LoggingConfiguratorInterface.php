<?php

namespace Electro\Interfaces\Logging;

use Monolog\Logger;

/**
 * A class responsible for configuring the application's main Monolog logger.
 *
 * This interface allows the application to override the framework's predefined logging configuration.
 */
interface LoggingConfiguratorInterface
{
  /**
   * Configures the main logger.
   *
   * <p>Use this method to add *formatters*, *handlers* and *processors* to it.
   *
   * @param Logger $logger The logger to be configured.
   * @return void
   */
  function configure (Logger $logger);

}
