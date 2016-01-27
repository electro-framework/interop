<?php
namespace Selenia\Interfaces\Views;

use Selenia\Exceptions\FatalException;

/**
 * The View service generates markup for displaying Graphical User Interfaces and web documents on web browsers.
 *
 * <p>It provides view template loading, compiling, caching and dynamic generation (rendering) capabilities.
 * <p>It can handle multiple templating engines via a single unified interface.
 */
interface ViewInterface
{
  /**
   * Passes a configuration callback to the view instance, which will be called upon instantiation of a specific
   * rendering engine. The callback receives the engine instance and returns nothing.
   *
   * @param callable $callback
   */
  function configure (callable $callback);

  /**
   * Gets the previously compiled view, if any.
   *
   * @return mixed|null
   */
  function getCompiledView ();

  /**
   * Gets the active view engine instance, if any.
   *
   * @return ViewEngineInterface|null
   */
  function getEngine ();

  /**
   * Loads and compiles the specified template file.
   *
   * @param string $path
   * @return $this
   */
  function loadFromFile ($path);

  /**
   * Compiles the given template.
   * > Don't forget to set a view engine before calling this method.
   *
   * @param string $src
   * @return $this
   */
  function loadFromString ($src);

  /**
   * Registes a view engine to be used for rendering files that match the given regular expression pattern.
   *
   * @param string $engineClass
   * @param string $filePattern A regular expression. Multiple patterns can be specified using the | operator.
   * @return $this
   */
  function register ($engineClass, $filePattern);

  /**
   * Renders the previously compiled template.
   *
   * @param array|object $data The view model; optional data for use by databinding expressions on the template.
   * @return string The generated output (ex: HTML).
   */
  function render ($data = null);

  /**
   * Instantiates the specified engine and sets it as the active engine for the view.
   *
   * @param string $engineClass
   * @return $this
   */
  function setEngine ($engineClass);

  /**
   * @param string $fileName
   * @return ViewEngineInterface
   * @throws FatalException If no match was found.
   */
  function setEngineFromFileName ($fileName);

}
