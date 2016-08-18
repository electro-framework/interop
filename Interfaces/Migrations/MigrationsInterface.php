<?php
namespace Electro\Interfaces\Migrations;

/**
 * A service that provides migration tasks.
 */
interface MigrationsInterface
{
  /**
   * Runs all pending migrations of the current module, optionally up to a specific version.
   *
   * @param string $target [optional] The version number to migrate to. If not specified, it runs up to the most recent
   *                       migration, either forward or backwards, depending on whether there are PENDING or
   */
  function migrate ($target = null);

  /**
   * Sets the target module for the subsequent migration operations.
   *
   * @param string $moduleName The target module (vendor-name/package-name syntax).
   * @return $this For chaining.
   */
  function module ($moduleName);

  /**
   * Rollback all database migrations of the current module.
   */
  function reset ();

  /**
   * Reverts the last migration of the current module, or optionally up to a specific version or date.
   *
   * @param string $target     [optional] The version number to migrate to.
   * @param string $date       [optional] The date to rollback to.
   */
  function rollback ($target = null, $date = null);

  /**
   * Runs all available seeders of the current module, or just a specific seeder.
   *
   * @param string $seeder     [optional] The name of the seeder (in camel case).
   */
  function seed ($seeder = 'Seeder');

  /**
   * Gets a list of all migrations of the current module, along with their current status.
   * <p>This can also be used to determine if a module has any migrations at all.
   *
   * @param bool   $onlyPending [optional] If true, only pending migrations will be returned.
   * @return array List of {@see MigrationStruct}
   */
  function status ($onlyPending = false);

}
