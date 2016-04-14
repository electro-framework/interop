<?php
namespace Selenia\Classes;

use Selenia\Traits\OverlayTrait;

/**
 * A class whose instances inherit properties at runtime from another object or from an array.
 *
 * <p>If the parent object also implements {@see OverlayInterface}, the inheritance chain propagates to that
 * object, and so on.
 */
class Overlay
{
  use OverlayTrait;

  /**
   * Overlay constructor.
   *
   * @param object|array $parent
   */
  public function __construct ($parent)
  {
    $this->_parent = $parent;
  }

  /**
   * @param object|array $parent
   * @return static
   */
  static public function from ($parent)
  {
    return new static($parent ?: []);
  }

}
