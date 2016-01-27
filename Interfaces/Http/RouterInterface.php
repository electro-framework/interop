<?php
namespace Selenia\Interfaces\Http;

/**
 * A service that assists in routing an HTTP request to one or more request handlers.
 * <p>A handler may generate an HTTP response and/or route to other handlers.
 * <p>The request will traverse a tree of interconnected handlers, until a full HTTP response is generated or the
 * tree traversal is completed.
 *
 * > Note that not all nodes on the tree will be visited, as most routes will not match the request's URL.
 *
 * If the handler tree is exhausted, the router sends the request to the next handler that was passed to it upon
 * invocation.
 *
 * > **Note:** internally, both this interface and MiddlewareStackInterface are implemented by the same class.
 * But that is just an implementation detail. When injecting instances of both interfaces, you'll still get
 * different behaviour from both.
 */
interface RouterInterface extends MiddlewareStackInterface
{
}
