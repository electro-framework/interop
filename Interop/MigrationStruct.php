<?php
namespace Electro\Interop;

/**
 * Defines structure information about an associative array containing information for a single migration.
 */
class MigrationStruct
{
  /** The migration has not run yet. */
  const DOWN = 'down';
  /** The migration has already run. */
  const UP = 'up';

  /**
   * @var string The date and time of the migration creation.
   *             <p>It defines the sorting order of the migration set.
   *             <p>Format: <code>'YYYYMMDDhhmmss'</code>
   */
  const date = 'date';
  /**
   * The primary key.
   */
  const id = 'id';
  /**
   * @var string The target module for the migration.
   */
  const module = 'module';
  /**
   * @var string The migration name.
   */
  const name = 'name';
  /**
   * @var string The SQL code that reverses the migration.
   */
  const reverse = 'reverse';
  /**
   * @var string The current migration state; either {@see MigrationInfo::UP} or {@see MigrationInfo::DOWN}.
   */
  const status = 'status';

}
