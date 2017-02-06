<?php

namespace Electro\Interfaces\Http\Shared;

use Psr\Http\Message\ServerRequestInterface;

/**
 * A service that allows access to the ServerRequestInterface instance at the current stage of middleware/routing.
 *
 * <p>When injecting this instance, instead of saving it in a class property as usual, you should instead save the
 * request instance obtained via `get()` to capture its current value, as it may change at a later time.
 */
interface CurrentRequestInterface
{
  /**
   * Gets the current request instance.
   *
   * @return ServerRequestInterface|null NULL if there is no request instance yet.
   */
  function get ();

  /**
   * Sets the current request instance.
   *
   * @param ServerRequestInterface $req
   * @return void
   */
  function set (ServerRequestInterface $req);
}
