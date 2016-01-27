<?php
namespace Selenia\Traits;

trait DecoratorTrait
{
  private $decorated;

  /**
   * @param string $n
   * @param array  $args
   */
  function __call ($n, $args)
  {
    $r  = new \ReflectionMethod ($this->decorated, $n);
    $fn = $r->getClosure ($this->decorated)->bindTo ($this, $this);
    return $fn (...$args);
  }

  /**
   * @param string $n
   */
  function __get ($n)
  {
    return $this->decorated->$n;
  }

  /**
   * @param string $n
   * @param mixed  $value
   */
  function __set ($n, $value)
  {
    $this->decorated->$n = $value;
  }

  /**
   * @param string $n
   * @return bool
   */
  function __isset ($n)
  {
    return isset($this->decorated->$n);
  }

  /**
   * @param string $n
   */
  function __unset ($n)
  {
    unset ($this->decorated->$n);
  }

}
