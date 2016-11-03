<?php
namespace Electro\Interfaces\Http;

/**
 * A class responsible for assembling the application's main middleware pipeline.
 *
 * This interface allows the application to override the framework's predefined middleware and assemble a completely
 * customized alternative.
 */
interface MiddlewareAssemblerInterface
{
  /**
   * Assembles the middleware pipeline.
   *
   * @param MiddlewareStackInterface $stack The stack to which middleware should be added.
   */
  function assemble (MiddlewareStackInterface $stack);
}
