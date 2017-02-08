<?php

namespace Electro\Interfaces\Http\Shared;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * A service that allows access to the ServerRequestInterface instance at the current stage of middleware/routing.
 *
 * <p>This class is {@see ServerRequestInterface} compatible and wraps a replaceable instance of it.
 * <p>You can use this wherever you would use a `ServerRequestInterface` instance; accessing its methods will invoke
 * the inner instance's methods.
 *
 * <p>You can call `get()` to get the current Request instance, but usually do not have to; you may use an instance
 * of this class as if it was the request itself.
 *
 * <p>Routers and middleware runners can set the current request by calling `set()`.
 */
interface CurrentRequestInterface extends RequestInterface
{
  /**
   * Gets the current request instance.
   *
   * @return ServerRequestInterface|null NULL if there is no request instance yet.
   */
  function getInstance ();

  /**
   * Sets the current request instance.
   *
   * @param ServerRequestInterface $req
   * @return void
   */
  function setInstance (ServerRequestInterface $req);
}
