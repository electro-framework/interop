<?php
namespace Electro\Interfaces;

/**
 * Indicates that a class provides custom logic for rending its inspection (debugging) representation.
 */
interface CustomInspectionInterface
{
  /**
   * Renders the instance's state and returns the resulting markup.
   *
   * @return string
   */
  function inspect ();

}
