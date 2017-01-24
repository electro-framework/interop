<?php
namespace Electro\Interop;

use Electro\Interfaces\MapInterface;

class Map implements MapInterface
{
  protected $_data = [];

  function __debugInfo ()
  {
    return $this->_data;
  }

  function __get ($key)
  {
    return isset($this->_data[$key]) ? $this->_data[$key] : null;
  }

  function __set ($key, $value)
  {
    if (isset($value))
      $this->_data[$key] = $value;
    else unset ($this->_data[$key]);
  }

  function __isset ($key)
  {
    return isset($this->_data[$key]);
  }

  function __unset ($key)
  {
    unset ($this->_data[$key]);
  }

  public function & asArray ()
  {
    return $this->_data;
  }

  function clear ()
  {
    $this->_data = [];
    return $this;
  }

  public function count ()
  {
    return count ($this->_data);
  }

  /**
   * Gets the element associated with the given key.
   *
   * <p>This is an alias of the `[ ]` indexing operator.
   *
   * ><p>**Note:** this method provides compatibility with other interfaces, like for instance, the
   * {@see \Interop\Container\ContainerInterface}.
   *
   * @param string $key
   * @return mixed
   */
  public function get ($key)
  {
    // TODO: Implement get() method.
  }

  public function getIterator ()
  {
    return new \ArrayIterator($this->_data);
  }

  public function has ($key)
  {
    return isset($this->_data[$key]);
  }

  public function keys ()
  {
    return array_keys ($this->_data);
  }

  public function serialize ()
  {
    return serialize ($this->_data);
  }

  public function set ($keyOrData, $value = null)
  {
    if (is_string ($keyOrData))
      $this->$keyOrData = $value;
    elseif (is_array ($keyOrData))
      $this->_data = $keyOrData + $this->_data;
    elseif ($keyOrData instanceof self)
      $this->_data = $keyOrData->_data + $this->_data;
    elseif ($keyOrData instanceof \IteratorAggregate)
      // optimized for speed, not memory
      $this->_data = iterator_to_array ($keyOrData->getIterator (), true) + $this->_data;
    else if (is_object ($keyOrData))
      $this->_data = get_object_vars ($keyOrData) + $this->_data;
    else throw new \InvalidArgumentException('Unsupported type ' . gettype ($keyOrData));
    return $this;
  }

  public function unserialize ($serialized)
  {
    $this->_data = unserialize ($serialized);
  }
}
