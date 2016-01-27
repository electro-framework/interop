<?php
namespace Selenia\Traits;

use Selenia\Interfaces\InjectorInterface;

/**
 * Provides a mechanism for a class to allow each subclass to define its own injections (besides the
 * contructor's) without having to repeat all the injections from the respective superclass(es) on its constructor.
 *
 * <p>Subclasses that define an `inject()` method will have that method called and dependency-injected after instantiation.
 *
 * All redefinitions of `inject()` troughout the class hierarchy will be called, in sequence, starting from the topmost
 * superclass and going down.
 *
 * <p>The expected `inject()` signature is: <kbd>void fn ($dependency1, ..., dependencyN)</kbd>
 *
 * @property InjectorInterface $injector
 * @method callable inject Override to return a callable that defines injectable parameters and returns nothing.
 */
trait PolymorphicInjectionTrait
{
  function polyInject ()
  {
    try {
      $m = new \ReflectionMethod($this, 'inject');
    }
    catch (\ReflectionException $e) {
      return; // Class has no inject()
    }
    $chain = [$m];
    try {
      while ($m = $m->getPrototype ()) {
        $chain[] = $m;
      }
    }
    catch (\ReflectionException $e) {
    }
    while (!empty ($chain)) {
      /** @var \ReflectionMethod $m */
      $method     = array_pop ($chain);
      $factory    = $method->getClosure ($this);
      $injectable = $factory ();
      if ($injectable)
        $this->injector->execute ($injectable);
    }
  }

}
