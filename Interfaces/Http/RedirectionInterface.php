<?php
namespace Selenia\Interfaces\Http;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;


/**
 * A service that creates an HTTP redirection response.
 *
 * > This service is not shared. When injected, you'll always get a new instance.
 */
interface RedirectionInterface
{
  /**
   * Creates a new redirection response to the previous location.
   * <p>If the previous location is not know, it redirects to the current URL.
   * @param int $status
   * @return \Psr\Http\Message\ResponseInterface
   */
  function back ($status = 302);

  /**
   * Attaches a server request object to this instance, for use on subsequent generated redirection responses.
   * > You MUST set a request object before using most other methods of this class.
   *
   * @param ServerRequestInterface $request
   * @return $this Self, for chaining.
   */
  function setRequest (ServerRequestInterface $request);

  /**
   * Creates a new redirection response, while saving the current URL in the session.
   * @param string|UriInterface $url    A relative or an absolute URL. If empty, it is equivalent to the current URL.
   * @param int                 $status HTTP status code.
   * @return \Psr\Http\Message\ResponseInterface
   */
  function guest ($url, $status = 302);

  /**
   * Creates a new redirection response to the application's root URL.
   * @param int $status
   * @return \Psr\Http\Message\ResponseInterface
   */
  function home ($status = 302);

  /**
   * Creates a new redirection response to the previously intended location, which is the one set previously by calling
   * `guest()`.
   * @param string|UriInterface $defaultUrl A relative or an absolute URL to be used when a saved URL is not found on
   *                                        the session. If empty, it is equivalent to the current URL.
   * @param int                 $status     HTTP status code.
   * @return \Psr\Http\Message\ResponseInterface
   */
  function intended ($defaultUrl = '', $status = 302);

  /**
   * Creates a new redirection response to the current URL.
   * @param int $status
   * @return \Psr\Http\Message\ResponseInterface
   */
  function refresh ($status = 302);

  /**
   * Creates a new redirection response to the given secure (https) URL.
   * @param string|UriInterface $url    A relative or an absolute URL. If empty, it is equivalent to the current URL.
   *                                    The protocol part is always replaced by 'https'.
   * @param int                 $status HTTP status code.
   * @return \Psr\Http\Message\ResponseInterface
   */
  function secure ($url, $status = 302);

  /**
   * Creates a new redirection response to the given URL.
   * @param string|UriInterface $url    A relative or an absolute URL. If empty, it is equivalent to the current URL.
   * @param int                 $status HTTP status code.
   * @return \Psr\Http\Message\ResponseInterface
   */
  function to ($url, $status = 302);
}
