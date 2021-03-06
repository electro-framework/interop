<?php

namespace Electro\Interfaces\Views;

use Electro\Exceptions\FatalException;

/**
 * A View represents a template that can be parsed, compiled and rendered to generate markup.
 *
 * <p>A View instance is not concerned with loading/caching templates.
 */
interface ViewInterface
{
  /**
   * Compiles the template.
   *
   * <p>For view engines that do not support template compilation, this method doesn't do anything.
   *
   * @return $this
   * @throws FatalException if no source code is set.
   */
  function compile ();

  /**
   * Gets the compiled template, if any.
   *
   * <p>For view engines that do not support template compilation, this returns null.
   *
   * @return mixed|null The compiled template. The data format is engine-dependent.
   */
  function getCompiled ();

  /**
   * Gets the associated rendering engine instance, if any.
   *
   * @return ViewEngineInterface|null
   */
  function getEngine ();

  /**
   * Returns the relative filesystem path of the template that originated this view, if a template was loaded.
   * Otherwise, returns `null`, which usually happens for dynamically generated views.
   *
   * <p>This is for informational purposes only; it is used for determining which view model class to instantiate for a
   * given view.
   *
   * <p>The path sould be relative to the module's views folder.
   *
   * @return string|null
   */
  function getPath ();

  /**
   * Gets the original source markup (the template).
   *
   * @return string
   */
  function getSource ();

  /**
   * Renders the view.
   *
   * <p>If the view is not compiled yet, it will be so before being rendered.
   *
   * @param ViewModelInterface $data The view model; optional data for use by databinding expressions on the template.
   * @return string The generated output (ex: HTML).
   * @throws FatalException if no template is set.
   */
  function render (ViewModelInterface $data = null);

  /**
   * Sets the compiled template.
   *
   * <p>For view engines that do not support template compilation, this has no effect.
   *
   * @param mixed $compiled The compiled template. The data format is engine-dependent.
   * @return $this Self, for chaining.
   */
  function setCompiled ($compiled);

  /**
   * Sets the view engine to be used for compiling and rendering the view.
   *
   * @param ViewEngineInterface $viewEngine
   * @return $this
   */
  public function setEngine (ViewEngineInterface $viewEngine);

  /**
   * Sets the relative filesystem path of the template that originated this view, if a template was loaded.
   *
   * <p>This is meaningless for dynamically generated views.
   *
   * <p>This is for informational purposes only; it is used for determining which view model class to instantiate for a
   * given view.
   *
   * <p>The path sould be relative to the module's views folder.
   *
   * @param string $path
   * @return $this
   */
  public function setPath ($path);

  /**
   * Sets the source code (the template).
   * <p>This also clears the current compiled template.
   *
   * @param string $src
   * @return $this Self, for chaining.
   */
  function setSource ($src);
}
