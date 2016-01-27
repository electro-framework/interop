<?php
namespace Selenia\Interfaces\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Renders an error HTTP response into a format supported by the client.
 */
interface ErrorRendererInterface
{
  /**
   * @param ServerRequestInterface $request  The request that was being handled when the error condition
   *                                         occurred.
   * @param ResponseInterface      $response The response should have a status code, reason phrase and body
   *                                         content that represent the error condition.
   * @param \Throwable|\Exception  $error    An optional error object for when the response should be rendered
   *                                         for an error/exception. You should supply this argument only for
   *                                         HTTP responses with status in the 500~599 range, as it causes
   *                                         debug information to be displayed on development mode.
   * @return ResponseInterface
   */
  function render (ServerRequestInterface $request, ResponseInterface $response, $error = null);
}
