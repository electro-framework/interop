<?php

namespace Electro\Interfaces\Views;

use Electro\Exceptions\FatalException;
use Electro\Interop\ViewModel;

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
   * Gets the original source markup (the template).
   *
   * @return string
   */
  function getSource ();

  /**
   * Returns the full filesystem path of the template that originated this view, if a template was loaded. Otherwise,
   * returns `null`, which usually happens for dynamically generated views.
   *
   * <p>This is for informational purposes only.
   *
   * @return string|null
   */
  function getTemplatePath ();

  /**
   * Renders the view.
   *
   * <p>If the view is not compiled yet, it will be so before being rendered.
   *
   * @param ViewModel $data The view model; optional data for use by databinding expressions on the template.
   * @return string The generated output (ex: HTML).
   * @throws FatalException if no template is set.
   */
  function render (ViewModel $data = null);

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
   * Sets the source code (the template).
   * <p>This also clears the current compiled template.
   *
   * @param string $src
   * @return $this Self, for chaining.
   */
  function setSource ($src);
}
