<?php

namespace Electro\Interfaces\Migrations;

/**
 * A service that provides migration tasks.
 *
 * ><p>**Note:** Although migrations and rollbacks are performed within database transactions, the database engine
 * might not support rolling back DDL statements.
 */
interface MigrationsInterface
{
  /**
   * Checks if migrations can be performed, for which a database connection must be available.
   *
   * @return bool
   */
  function databaseIsAvailable ();

  /**
   * Runs all pending migrations of the current module, optionally up to a specific version.
   *
   * @param string $target  [optional] The upper limit timestamp to migrate up to (ex: 20170314150049), inclusive;
   *                        migrations with timestamps greater than it will be excluded; if not specified, it runs all
   *                        pending migrations.
   * @param bool   $pretend If true, the migration is not actually run and the SQL code that would be executed is
   *                        returned.
   * @param bool   $rollbackObsolete Rollback obsoletes migrations
   * @return int|string If $pretend==true, it returns the SQL code, otherwhise it returns the number of migrations
   *                        executed.
   */
  function migrate ($target = null, $pretend = false, $rollbackObsolete = false);

  /**
   * Sets the target module for the subsequent migration operations.
   *
   * @param string $moduleName The target module (vendor-name/package-name syntax).
   * @return $this For chaining.
   */
  function module ($moduleName);

  /**
   * Reverts the last migration of the current module, or optionally up to a specific version or date.
   *
   * @param string $target  [optional] The lower limit timestamp to rollback to (ex: 20170314150049), inclusive;
   *                        migrations with timestamps lower than it will be excluded; 0 = roll back all migrations.
   *                        If not given, the last migration will be rolled back.
   * @param bool   $pretend If true, the migration is not actually run and the SQL code that would be executed is
   *                        returned.
   * @return int|string If $pretend==true, it returns the SQL code, otherwise it returns the number of migrations
   *                        executed.
   */
  function rollBack ($target = null, $pretend = false);

  /**
   * Runs all available seeders of the current module, or just a specific seeder.
   *
   * @param string $seeder  [optional] The name of the seeder (in camel case).
   * @param array  $options Configuration options for the seeding process.<dl>
   *                        <dt>'pretend' => bool
   *                        <dd>If true, the seeder is not actually run and the SQL code that would
   *                        be executed is returned.
   *                        <dt>'clear' => bool
   *                        <dd>if true, data is cleared from each target table before it's seeded.
   *                        </dl>
   * @return int|string If $pretend==true, it returns the SQL code, otherwhise it returns the number of seeders
   *                        executed.
   */
  function seed ($seeder = 'Seeder', array $options = []);

  /**
   * Gets a list of all migrations of the current module, along with their current status.
   * <p>This can also be used to determine if a module has any migrations at all.
   *
   * @param bool $onlyPending [optional] If true, only pending migrations will be returned.
   * @return array List of {@see MigrationStruct}
   */
  function status ($onlyPending = false);

}
