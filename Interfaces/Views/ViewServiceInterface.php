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
   * Attempts to create a view model for the specified view.
   *
   * @param ViewInterface|null $view    The target view or NULL to return a generic view model (when $default=null).
   * @param bool               $default When TRUE, a default view model will be returned if no mapping was found.
   * @return ViewModelInterface|null NULL if a custom view model class could not be determined and $default is FALSE.
   */
  function createViewModelFor (ViewInterface $view = null, $default = false);

  /**
   * Gets an engine instance with the specified class.
   *
   * @param string $class
   * @param array  $options Passes the given object or array to the view engine.
   *                        It may be anything that the engine needs to perform the compilation or rendering steps.
   *                        It applies only to the returned instance.
   * @return ViewEngineInterface
   */
  function getEngine ($class, $options = []);

  /**
   * @param string $path    The complete file name, including the file name extension.
   * @param array  $options Passes the given object or array to the view engine.
   *                        It may be anything that the engine needs to perform the compilation or rendering steps on
   *                        this specific file.
   * @return ViewEngineInterface
   * @throws FatalException If no match was found.
   */
  function getEngineFromFileName ($path, $options = []);

  /**
   * Retrieves the compiled template for the specified file from a template cache; if it's not cached, this method
   * loads the file, compiles it and caches it for future requests.
   *
   * @param string $viewPath A relative file name (from a module's views directory), possibly excluding the file name
   *                         extension.
   * @param array  $options  Passes the given object or array to the view engine.
   *                         It may be anything that the engine needs to perform the compilation or rendering steps on
   *                         this specific file.
   * @return ViewInterface
   */
  function loadFromFile ($viewPath, array $options = []);

  /**
   * Compiles the given template.
   * > Don't forget to set a view engine before calling this method as the engine to use can't be inferred from a
   * string template.
   *
   * @param string                     $src
   * @param string|ViewEngineInterface $engineOrClass The view engine's class name or an instance of it.
   * @param array                      $options       Passes the given object or array to the view engine.
   *                                                  It may be anything that the engine needs to perform the
   *                                                  compilation or rendering steps on this specific template.
   * @return ViewInterface
   */
  function loadFromString ($src, $engineOrClass, array $options = []);

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
  function resolveTemplatePath ($viewName, &$base = null);
}
