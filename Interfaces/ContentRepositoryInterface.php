<?php

namespace Electro\Interfaces;

use Psr\Http\Message\UploadedFileInterface;

interface ContentRepositoryInterface
{
  /**
   * Removes a file and all related cached files from the repository.
   *
   * @param string $virtualPath The file's relative path on the repository.
   * @return mixed
   */
  public function deleteFile ($virtualPath);

  /**
   * Get the URL of a file in the content repository.
   *
   * <p>If `$path` is `null` or `''`, `''` is returned.
   *
   * @param  string $path The virtual resource path.
   * @return string The URL to retrieve the file.
   */
  public function getFileUrl ($path);

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

  /**
   * Saves a file into the repository.
   *
   * @param string          $repoPath The file's relative path on the repository.
   * @param string|resource $file     A pysical file path or a readable stream.
   * @param  string         $mime     The file's MIME type (ex. 'image/jpeg').
   * @throws \League\Flysystem\FileExistsException
   * @throws \League\Flysystem\InvalidArgumentException
   */
  public function saveFile ($repoPath, $file, $mime);

  /**
   * Saves an uploaded file into the repository.
   *
   * @param string                $virtualPath The file's relative path on the repository.
   * @param UploadedFileInterface $file        The uploaded file instance, obtained from {@see ServerRequestInterface}.
   * @throws \League\Flysystem\FileExistsException
   * @throws \League\Flysystem\InvalidArgumentException
   * @throws \InvalidArgumentException
   */
  public function saveUploadedFile ($virtualPath, UploadedFileInterface $file);

}
