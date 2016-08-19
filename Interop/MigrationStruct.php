<?php
namespace Electro\Interop;

/**
 * Defines structure information about an associative array containing information for a single migration.
 */
class MigrationStruct
{
  /** The migration has already run. */
  const DONE = 'done';
  /** The migration no longer exists on the project. */
  const OBSOLETE = 'obsolete';
  /** The migration has not run yet. */
  const PENDING = 'pending';
  /**
   * @var string The date and time of the migration creation. This is the table's primary key.
   *             <p>It also defines the sorting order of the migration set.
   *             <p>Format: <code>'YYYYMMDDhhmmss'</code>
   */
  const date = 'date';
  /**
   * @var string The target module for the migration.
   */
  const module = 'module';
  /**
   * @var string The migration name.
   */
  const name = 'name';
  /**
   * @var string The file path of the corresponding migration file (if it exists).
   *             <p>Note: this field is computed, it's not present on the database.
   */
  const path = 'path';
  /**
   * @var string The SQL code that reverses the migration.
   */
  const reverse = 'reverse';
  /**
   * @var string The current migration state; either {@see MigrationInfo::UP} or {@see MigrationInfo::DOWN}.
   *             <p>Note: this field is computed, it's not present on the database.
   */
  const status = 'status';

  static public function classFromFilename ($path)
  {
    return ucfirst (str_dehyphenate (str_segmentsStripFirst (
      pathinfo ($path)['filename'], '_'), true, '_'));
  }

  static public function nameFromFilename ($path)
  {
    return ucfirst (str_decamelize (str_dehyphenate (str_segmentsStripFirst (
      pathinfo ($path)['filename'], '_'), true, '_')));
  }

  static public function toDateStr ($compactDate)
  {
    return preg_replace ('/(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)/', '$1-$2-$3 $4:$5:$6', $compactDate);
  }

}
