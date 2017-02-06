<?php

namespace Electro\Interfaces\Logging;

/**
 * A class responsible for creating and configuring the application's logging system, which is composerd of loggers,
 * handlers, processors and formatters.
 *
 * This interface allows the application to override the framework's predefined logging configuration.
 */
interface LoggingSetupInterface
{
  /**
   * Configures the application's logging system.
   *
   * <p>The method must define **at least** one logger named `general` (see the `LOG_GENERAL` constant}.
   *
   * @param LogCentralInterface $logCentral
   * @return void
   */
  function setup (LogCentralInterface $logCentral);

}
