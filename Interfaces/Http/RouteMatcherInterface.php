<?php
namespace Selenia\Interfaces\Http;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Represents a service that Implements a specific flavour of the DSL route pattern matching syntax.
 */
interface RouteMatcherInterface
{
  /**
   * Matches a request's URL against a route matching pattern.
   *
   * <p>This method returns a new request object with a new path that results from the matched portion of the original
   * one being consumed.
   * > The new path may equals the original path if the pattern matches the initial location itself, and not a
   * sub-location.
   *
   * The new request object also provides all the route parameters defined on the pattern as request attributes with
   * names prefixed by `@`.
   *
   * @param string                 $pattern         The route matching pattern. See the routing documentation for
   *                                                details about the DSL syntax.
   * @param ServerRequestInterface $request         The HTTP request whose URL will be matched against the given
   *                                                pattern.
   * @param ServerRequestInterface $modifiedRequest (output parameter) outputs the new request object, if changes to
   *                                                the original are performed, otherwise it outputs the original
   *                                                request.
   * @return bool true if the pattern matches the path.
   */
  function match ($pattern, ServerRequestInterface $request, ServerRequestInterface &$modifiedRequest);
}
