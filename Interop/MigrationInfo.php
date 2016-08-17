<?php
namespace Electro\Interop;

class MigrationInfo
{
  const UP   = 'up';
  const DOWN = 'down';

  /**
   * @var string The migration name.
   */
  public $name;
  /**
   * @var string The date and time of the migration creation. Defines the sorting order of the migration set.
   */
  public $date;
  /**
   * @var string The current migration state; either {@see MigrationInfo::UP} or {@see MigrationInfo::DOWN}.
   */
  public $status;

}
