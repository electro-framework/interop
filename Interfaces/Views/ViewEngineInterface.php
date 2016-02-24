<?php
namespace Selenia\Interfaces\Views;

/**
 * A low-level API to a view/templating engine, which is capable of compiling and/or rendering templates coded in a
 * specific templating language.
 */
interface ViewEngineInterface
{
  /**
   * Compiles the given template.
   *
   * @param string $src The source markup (ex: HTML). When called from a View, this is guaranteed to be non-null.
   * @return mixed|null The compiled template or `null` if the engine does not support template compilation.
   */
  function compile ($src);

  /**
   * Passes the given object or array to the view engine. It may be anything that the engine needs to perform the
   * compilation or rendering steps.
   *
   * @param mixed $options
   */
  function configure ($options);

  /**
   * @param mixed        $template The compiled template,or the original source code if the engine does not support
   *                               template compilation. When called from a View, this is guaranteed to be non-null.
   * @param array|object $data     The view model; optional data for use by databinding expressions on the template.
   * @return string The generated output (ex: HTML).
   */
  function render ($template, $data = null);

}
