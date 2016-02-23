<?php
namespace Selenia\Interfaces\Views;

/**
 * A View represents a template that can be interpreted, compiled and rendered to generate markup.
 */
interface ViewInterface
{
  /**
   * Compiles the template.
   *
   * @return $this
   */
  function compile ();

  /**
   * Gets the compiled template, if any.
   *
   * @return mixed|null
   */
  function getCompiled ();

  /**
   * Gets the associated rendering engine instance, if any.
   *
   * @return ViewEngineInterface|null
   */
  function getEngine ();

  /**
   * Gets the original source code (the template).
   *
   * @return string
   */
  function getSource ();

  /**
   * Renders the previously compiled template.
   *
   * @param array|object $data The view model; optional data for use by databinding expressions on the template.
   * @return string The generated output (ex: HTML).
   */
  function render ($data = null);

  /**
   * Sets the source code (the template).
   * <p>This also clears the current compiled template.
   *
   * @param string $src
   * @return $this
   */
  function setSource ($src);

}
