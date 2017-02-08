<?php

namespace Electro\Interop;

/**
 * Wraps an injectable callable.
 *
 * <p>This can be use to mark a callable as being injectable.
 * <pUsing this class is necessary when one needs to create a reference to an injectable function, but an injector
 * is not available at that time.
 * <p>An injector **must** be available when this instance is to be called.
 * <p>To call and inject the original callable, just do:
 *       $injector->execute ($instance ())
 *
 * <p>A typical use case for this is routing.
 * <p>When a router or a middleware stack are about to invoke a routable, they check if it is an instance of this class
 * and, if it is, instead of calling it with the standard request handler arguments `($request, $response, $next)`,
 * they use an injector to invoke the original callable and then invoke the resulting `Closure` as middleware.
 */
class InjectableFunction
{
  /** @var callable */
  private $fn;

  /**
   * Saves an injectable callable for later retrieval.
   *
   * @param callable $fn
   */
  public function __construct (callable $fn)
  {
    $this->fn = $fn;
  }

  /**
   * Returns the saved injectable callable.
   *
   * @return callable
   */
  function __invoke ()
  {
    return $this->fn;
  }

}
