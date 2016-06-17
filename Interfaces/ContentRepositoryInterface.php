<?php
namespace Electro\Interfaces;

interface ContentRepositoryInterface
{
  /**
   * Get the URL of an image in the content repository, with optional processing settings.
   *
   * <p>If `$path` is `null` or `''`, `''` is returned.
   *
   * @param  string $path   The virtual resource path.
   * @param  array  $params A map of manipulation parameters.
   * @return string The URL to retrieve the image.
   */
  public function getImageUrl ($path, array $params = []);

}
