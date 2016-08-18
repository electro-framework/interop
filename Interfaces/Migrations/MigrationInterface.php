<?php
namespace Electro\Interfaces\Migrations;

/**
 * A class that implements a single migration.
 */
interface MigrationInterface
{
  /**
   * Performs the migration.
   */
  function up ();

  /**
   * Reverses the migration.
   */
  function down ();

}
