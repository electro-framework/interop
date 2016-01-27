<?php
namespace Selenia\Interfaces\Views;

/**
 * A low-level API to a single view/templating engine, which is capable of compiling and rendering templates coded in a
 * specific templating language.
 */
interface ViewEngineInterface
{
  /**
   * Passes the given object or array to the view engine. It may be anything that the engine needs to perform the
   * compilation or rendering steps,
   *
   * @param mixed $options
   */
  function configure ($options);
  /**
   * Compiles the given template.
   * @param string $src The source markup (ex: HTML).
   * @return mixed The compiled template.
   */
  function compile ($src);

  /**
   * @param mixed        $compiled The compiled template.
   * @param array|object $data     The view model; optional data for use by databinding expressions on the template.
   * @return string The generated output (ex: HTML).
   */
  function render ($compiled, $data = null);

}
