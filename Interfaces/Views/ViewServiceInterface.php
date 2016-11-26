<?php
namespace Electro\Interfaces\Views;

use Electro\Exceptions\Fatal\FileNotFoundException;
use Electro\Exceptions\FatalException;

/**
 * The View service generates markup for displaying Graphical User Interfaces and web documents on web browsers.
 *
 * <p>It provides view template loading, compiling, caching and dynamic generation (rendering) capabilities.
 * <p>It can handle multiple templating engines via a single unified interface.
 */
interface ViewServiceInterface
{

  /**
   * Gets an engine instance with the specified class.
   *
   * @param string $class
   * @return ViewEngineInterface
   */
  function getEngine ($class);

  /**
   * @param string $path The complete file name, including the file name extension.
   * @return ViewEngineInterface
   * @throws FatalException If no match was found.
   */
  function getEngineFromFileName ($path);

  /**
   * Retrieves the compiled template for the specified file from a template cache; if it's not cached, this method
   * loads the file, compiles it and caches it for future requests.
   *
   * @param string $path The complete file name, including the file name extension.
   * @return ViewInterface
   * @throws FileNotFoundException If no file is found with the given name or having that name as prefix.
   */
  function loadFromFile ($path);

  /**
   * Compiles the given template.
   * > Don't forget to set a view engine before calling this method as the engine to use can't be inferred from a
   * string template.
   *
   * @param string                     $src
   * @param string|ViewEngineInterface $engineOrClass The view engine's class name or an instance of it.
   * @return ViewInterface
   */
  function loadFromString ($src, $engineOrClass);

  /**
   * Attempts to load the specified view file.
   *
   * @param string $path The complete file name, including the file name extension.
   * @return string The file's content.
   * @throws FileNotFoundException If no file is found with the given name or having that name as prefix.
   */
  public function loadViewTemplate ($path);

  /**
   * Registes a view engine to be used for rendering files that match the given regular expression pattern.
   *
   * @param string $engineClass
   * @param string $filePattern A regular expression. Multiple patterns can be specified using the | operator.
   * @return $this
   */
  function register ($engineClass, $filePattern);

  /**
   * Searches for the specified view file and returns the absolute path to it.
   *
   * If no file with the given name is found, a search is made for the first file on the same directory that has the
   * same name as prefix but that also has one or more additional extensions. Ex: 'my-template' --> 'my-template.html'
   *
   * @param string $viewName
   * @param string $base [output, optional] It will be set to the base path of the module's views folder.
   * @return string An absolute file path.
   * @throws FileNotFoundException If the file was not found.
   */
  public function resolveTemplatePath ($viewName, &$base = null);

}
