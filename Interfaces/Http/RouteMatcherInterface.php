<?php
namespace Electro\Interfaces\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Represents a service that Implements a specific flavour of the DSL route pattern matching syntax.
 */
interface RouteMatcherInterface
{
  /**
   * Matches a request's URL against a route matching pattern.
   *
   * <p>Whan the match is successful, this method returns a new request object with a new URL path that results from the
   * matched portion of the original URL path being consumed.
   * > The new path may equal the original path if the pattern matches the initial location itself, and not a
   * sub-location.
   *
   * The new request object also provides all the route parameters defined on the pattern as request attributes with
   * names prefixed by `@`.
   *
   * @param string                 $pattern         The route matching pattern. See the routing documentation for
   *                                                details about the DSL syntax.
   * @param ServerRequestInterface $request         The HTTP request whose URL will be matched against the given
   *                                                pattern.
   * @return ServerRequestInterface|bool false if the pattern doesn't match the path, a modified request instance
   *                                                otherwhise.
   */
  function match ($pattern, ServerRequestInterface $request);
}
