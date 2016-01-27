<?php
namespace Selenia\Interfaces\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

interface ResponseFactoryInterface
{

  /**
   * Creates a new HTTP response object, compatible with ResponseInterface.
   * @param int    $status
   * @param string $content
   * @param string $contentType
   * @param array  $headers
   * @return ResponseInterface
   */
  function make ($status = 200, $content = '', $contentType = 'text/html', array $headers = []);

  /**
   * Creates a new stream from the specified string, for use as an HTTP response body.
   * @param string          $content Initial body content.
   * @param string|resource $stream  Stream identifier and/or an actual stream resource.
   * @return StreamInterface
   */
  function makeBody ($content = '', $stream = 'php://memory');

  /**
   * Creates an HTML response with the given content.
   * <p>This is a convenience method.
   * @param string $content
   * @return ResponseInterface
   */
  function makeHtmlResponse ($content = '');

  /**
   * Creates a JSON response for the given data.
   * <p>This is a convenience method.
   * @param mixed $data
   * @return ResponseInterface
   */
  function makeJsonResponse ($data);

  /**
   * Creates a new HTTP response object, compatible with ResponseInterface.
   * @param string|resource|StreamInterface $stream  Stream identifier and/or actual stream resource
   * @param int                             $status  Status code for the response, if any.
   * @param array                           $headers Headers for the response, if any.
   * @throws \InvalidArgumentException on any invalid element.
   * @return ResponseInterface
   */
  function makeStream ($stream = 'php://memory', $status = 200, array $headers = []);

}
