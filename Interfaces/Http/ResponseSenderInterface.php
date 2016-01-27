<?php
namespace Selenia\Interfaces\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * A service that streams a `ResponseInterface`-compatible object to the HTTP client (for example, a web browser).
 */
interface ResponseSenderInterface
{
  /**
   * Sends a response to the HTTP client, with its status, headers and content.
   * @param ResponseInterface $response
   */
  function send (ResponseInterface $response);
}
