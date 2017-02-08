<?php

namespace Electro\Interfaces\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

interface ResponseFactoryInterface
{

  /**
   * Creates a new HTTP response object, compatible with ResponseInterface.
   *
   * @param int    $status      HTTP status code.
   * @param string $content     The message content, as a string.
   * @param string $contentType If empty, no content type header will be set.
   * @param array  $headers     HTTP response headers.
   * @return ResponseInterface
   */
  function make ($status = 200, $content = '', $contentType = '', array $headers = []);

  /**
   * Creates a new stream from the specified string, for use as an HTTP response body.
   *
   * @param string          $content Initial body content.
   * @param string|resource $stream  Stream identifier and/or an actual stream resource.
   * @return StreamInterface
   */
  function makeBodyStream ($content = '', $stream = 'php://memory');

  /**
   * Creates a new HTTP response object, compatible with ResponseInterface.
   *
   * @param string|resource|StreamInterface $stream  Stream identifier and/or actual stream resource
   * @param int                             $status  Status code for the response, if any.
   * @param array                           $headers Headers for the response, if any.
   * @throws \InvalidArgumentException on any invalid element.
   * @return ResponseInterface
   */
  function makeFromStream ($stream = 'php://memory', $status = 200, array $headers = []);

  /**
   * Creates an HTML response with the given content.
   * <p>This is a convenience method.
   *
   * @param string $content
   * @return ResponseInterface
   */
  function makeHtmlResponse ($content = '');

  /**
   * Creates a JSON response for the given data.
   * <p>This is a convenience method.
   *
   * @param mixed $data
   * @return ResponseInterface
   */
  function makeJsonResponse ($data);

}
