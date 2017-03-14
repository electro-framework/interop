<?php

namespace Electro\Interfaces\Views;

use Electro\Exceptions\Fatal\FileNotFoundException;
use Electro\Exceptions\FatalException;
use Electro\Interfaces\EventEmitterInterface;

/**
 * Use this event to inspect or modify view models as they are created prior to the corresponding views being rendered.
 */
const CREATE_VIEW_MODEL = 0;

/**
 * Use this event to intercept the rendering of views right before it begins.
 */
const RENDER = 1;

/**
 * The View service generates markup for displaying Graphical User Interfaces and web documents on web browsers.
 *
 * <p>It provides view template loading, compiling, caching and dynamic generation (rendering) capabilities.
 * <p>It can handle multiple templating engines via a single unified interface.
 */
interface ViewServiceInterface extends EventEmitterInterface
{
  /**
   * Attempts to create a view model for the specified view.
   *
   * <p>It also emits the `CREATE_VIEW_MODEL` event.
   *
   * @param ViewInterface|null $view    The target view or NULL to return a generic view model (when $default=null).
   * @param bool               $default When TRUE, a default view model will be returned if no mapping was found.
   * @return ViewModelInterface|null NULL if a custom view model class could not be determined and $default is FALSE.
   */
  function createViewModelFor (ViewInterface $view = null, $default = false);

  /**
   * Gets or sets the current view being rendered.
   *
   * <p>This is meant for informational purposes only. For ex. it may be used during rendering to determine which
   * module the view belongs to.
   *
   * @param ViewInterface|null $view
   * @return ViewInterface
   */
  function currentView (ViewInterface $view = null);

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
   * Returns the name of the module that contains the template with a given relative path.
   *
   * @param string $path
   * @return string
   */
  function getModuleOfPath ($path);

  /**
   * Tries to find a View Model class name for the specified template.
   *
   * @param string $templatePath
   * @return null|string NULL if a class name could not be determined, otherwise a fully qualified class name.
   * @throws FileNotFoundException
   */
  function getViewModelClass ($templatePath);

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
   * Registers an event handler for the `CREATE_VIEW_MODEL` event.
   *
   * <p>Use this event to inspect or modify view models as they are created prior to the corresponding views being
   * rendered.
   *
   * @param callable $handler function (ViewModelInterface, ViewInterface)
   * @return $this
   */
  function onCreateViewModel (callable $handler);

  /**
   * Registers an event handler for the `RENDER` event.
   *
   * <p>Use this event to intercept the rendering of views right before it begins.
   *
   * @param callable $handler function (ViewModelInterface, ViewInterface)
   * @return $this
   */
  function onRenderView (callable $handler);

  /**
   * Registes a view engine to be used for rendering files that match the given regular expression pattern.
   *
   * @param string $engineClass
   * @param string $filePattern A regular expression. Multiple patterns can be specified using the | operator.
   * @return $this
   */
  function register ($engineClass, $filePattern);

  /**
   * Searches for the specified view file on all registered template directories and, if found, returns the absolute
   * path to it.
   *
   * If no file with the given name is found, a search is made for the first file on the same directory that has the
   * same name as prefix but that also has one or more additional extensions. Ex: 'my-template' --> 'my-template.html'
   *
   * @param string $path     A file path relative to the project's root directory or relative to one of the project's
   *                         module's views directory.
   * @param string $base     [output, optional] It will be set to the base path of the module's views directory where
   *                         the file was found.
   * @param string $viewPath [output, optional] It will be set to a relative path from the module's views directory
   *                         where the file was found.
   * @return string An absolute file path.
   * @throws FileNotFoundException If the file was not found.
   */
  function resolveTemplatePath ($path, &$base = null, &$viewPath = null);


}
