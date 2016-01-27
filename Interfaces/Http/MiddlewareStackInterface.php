<?php
namespace Selenia\Interfaces\Http;

/**
 * A pipeline of request handlers.
 *
 * <p>By invoking the instance, the pipeline is executed and a response for the given request should be generated.
 *
 * > There are no methods to retrieve the content of the pipeline; this is by design.
 *
 * > <p>**Note:** instances are not immutable, but if you need immutability, calling `with()` returns a new instance.
 *
 * > **Note:** internally, both this interface and RouterInterface are implemented by the same class.
 * But that is just an implementation detail. When injecting instances of both interfaces, you'll still get
 * different behaviour from both.
 */
interface MiddlewareStackInterface extends RequestHandlerInterface
{
  /**
   * Adds a request handler to the pipeline.
   * @param string|callable|RequestHandlerInterface $handler The request handler to be added to the pipeline.
   * @param string|int|null                         $key     An ordinal index or an arbitrary identifier to associate
   *                                                         with the given handler.
   *                                                         <p>If not specified, an auto-incrementing integer index
   *                                                         will be assigned.
   *                                                         <p>If an integer is specified, it may cause the handler to
   *                                                         overwrite an existing handler at the same ordinal position
   *                                                         on the pipeline.
   *                                                         <p>String keys allow you to insert new handlers after a
   *                                                         specific one.
   *                                                         <p>Some MiddlewareStackInterface implementations
   *                                                         may use the key for other purposes (ex. route matching
   *                                                         patterns).
   * @param string|int|null                         $after   Insert after an existing handler that lies at the given
   *                                                         index, or that has the given key. When null, it is
   *                                                         appended.
   * @return $this
   */
  function add ($handler, $key = null, $after = null);

  /**
   * Sets the pipeline to the given one.
   * <p>This method mutates the object.
   *
   * @param mixed $handlers An array, Traversable, callable or class name. If the argument is a handler, it's equivalent
   *                        to creating a pipeline with a single handler (but it may not be implemented as such).
   * @return $this
   */
  function set ($handlers);

  /**
   * Creates a new instance of the same class with the given pipeline.
   *
   * @param mixed $handlers An array, Traversable, callable or class name. If the argument is a handler, it's equivalent
   *                        to creating a pipeline with a single handler (but it may not be implemented as such).
   * @return $this
   */
  function with ($handlers);

}
