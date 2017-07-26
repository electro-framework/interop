<?php
namespace Electro\Interfaces\DI;

/**
 * TODO: NOT YET IMPLEMENTED!
 *
 * Provides a mechanism for a class to define an alternate method of injecting dependencies instead of the constructor.
 *
 * <p>When the onjector is instantiating classes, if they implement this interface, it will invoke the `inject()`
 * provisionalble method on them.
 *
 * <p>Your class must provide an `inject()` method that will return a callable with the following signature:
 * ><kbd>public function fn ($dependency1, ..., dependencyN):void</kbd>
 *
 * <p>**Warning:** only the lowest `inject()` method on the class hierarchy will be invoked. If you need cascading, see
 * {@see PolymorphicInjectionTrait}.
 *
 * @method callable inject Declare this method on your class to define injectable parameters. It should return nothing.
 */
interface SideInjectionInterface
{
}
