<?php
namespace Electro\Traits;

/**
 * Allows instances of the class to inherit and override properties and methods at runtime from another object.
 *
 * <p>You should assign the `decorated` property before using the object. You can do that on the class constructor, or
 * you may create a setter.
 * <p>**Warning:** you cannot use `parent::` on a class that uses this trait. Use `$this->decorated->`, instead.
 * <p>**Warning:** there are limitations to what a decorated class can do. For ex. it cannot be passed as an argument
 * to a function that has a typehint to the original class.
 * <p>**Warning:** this class uses reflection to run the decorated class methods on the context of the decorator and to
 * be able to access private/protected properties and methods; so it's slower than the decorated class.
 */
trait DecoratorTrait
{
  private $decorated;

  /**
   * @param string $n
   * @param array  $args
   * @return mixed
   */
  function __call ($n, $args)
  {
    // return call_method ([$this->decorated, $n], $this, ...$args);
    return call_user_func_array ([$this->decorated, $n], $args);
  }

  /**
   * @param string $n
   * @return mixed
   */
  function __get ($n)
  {
    $m = new \ReflectionProperty($this->decorated, $n);
    $m->setAccessible (true);
    return $m->getValue ($this->decorated);
  }

  /**
   * @param string $n
   * @param mixed  $value
   */
  function __set ($n, $value)
  {
    $m = new \ReflectionProperty($this->decorated, $n);
    $m->setAccessible (true);
    $m->setValue ($this->decorated, $value);
  }

  /**
   * @param string $n
   * @return bool
   */
  function __isset ($n)
  {
    $c = new \ReflectionClass($this->decorated);
    return $c->hasProperty ($n) && !is_null ($this->__get ($n));
  }

  /**
   * @param string $n
   */
  function __unset ($n)
  {
    $this->__set ($n, null);
  }

}
