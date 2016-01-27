<?php
namespace Selenia\Traits;

define ('Y', true);
define ('N', false);

/**
 * Provides the capability of setting class instance properties by using virtual fluent (chainable) setter methods.
 * <p>The actual properties (having the same name as the virtual methods that access them) should, usually, have
 * private/protected visibility, so that they won't show up on IDE autocompletions.
 *
 * ### Setting properties
 *
 * Call a virtual method with the same name of the property and with one or more arguments.
 * <p>Ex:
 * ```
 *   $a->prop1 (true)->prop2 ('test')->prop3(1,2,3)->prop3->([1,2,3]);
 * ```
 *
 * ### Reading properties
 *
 * Call a virtual method with the same name of the property and with no arguments.
 * <p>Ex:
 * ```
 *   $x = $a->prop1 ();
 * ```
 *
 * ### Setting array properties
 *
 * If the setter is invoked with 2 or more arguments, it is assumed to be setting an array property with an
 * array value consisting of those arguments.<br>
 * If the setter is invoked with a single argument, it must be an array argument, as it will be assigned
 * directly to the property.
 * <p>Ex:
 * ```
 *   class A {
 *   use FluentAPI;
 *     private $a = [];
 *     private $b;
 *   }
 *   (new A)->a ([1);     // a = [1]
 *   (new A)->a (1);      // a = 1      //incorrect
 *   (new A)->a (1,2);    // a = [1,2]
 *   (new A)->a (null);   // a = null
 *   (new A)->a ([null]); // a = [null]
 * ```
 *
 * ### Setting boolean properties
 *
 * > **Note:** You can use the `Y` and `N` constants (Yes and No) as alias to `true` and `false`
 *
 * Ex:
 * ```
 *   class A {
 *   use FluentAPI;
 *     private $enabled;
 *   }
 *   (new A)->enabled (true);   // enabled = true
 *   (new A)->enabled (Y);      // enabled = true
 *   (new A)->enabled (N);      // enabled = false
 * ```
 *
 * ### Enabling IDE auto-completion and code analysis
 *
 * You should declare the virtual methods as PHPDOC comments.
 * <p>Ex:
 * > <kbd> `@`method $this|boolean enabled (boolean $v = null)</kbd>
 *
 * <p>Note:
 * > although the PHPDOC virtual method signature implies that not passing an argument is equivalent to
 * passing a `null` value, the real virtual method will distinguish between those two scenarios.
 */
trait FluentTrait
{
  /**
   * It's triggered when invoking inaccessible methods in an object context.
   *
   * @param $name  string
   * @param $args  array
   * @return $this
   */
  function __call ($name, $args)
  {
    if (!property_exists ($this, $name))
      throw new \RuntimeException (sprintf (
        "Property '<kbd>$name</kbd>' does not exist on class <kbd class=class>%s</kbd>",
        get_class ($this)));
    switch (count ($args)) {
      case 0:
        return $this->$name;
      case 1:
        $this->$name = $args[0];
        break;
      default:
        $this->$name = $args;
    }
    return $this;
  }

}
