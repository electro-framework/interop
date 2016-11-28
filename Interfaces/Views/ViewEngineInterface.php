<?php
namespace Electro\Interfaces\Views;

use Electro\Caching\Lib\CachingFileCompiler;

/**
 * A low-level API to a view/templating engine, which is capable of compiling and/or rendering templates coded in a
 * specific templating language.
 *
 * ><p>**Warning:** do not share globally a single instance of this class; each {@see ViewInterface} instance should own
 * a distinct engine instance for correct operation.
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
   * Passes the given configuration associative array to the view engine.
   *
   * <p>The array should contain a map of option names to option values, which are engine-specific and are meant to
   * configure the engine for operation. They remain in effect until changed.
   *
   * >**Note:** although the configuration is permanent, each {@see ViewInterface} instance owns a distinct engine
   * instance, so actually, the configuration set via this method applies to a single view.
   *
   * @param array $options
   */
  function configure (array $options = []);

  /**
   * Returns the compiled representation of a given source code file, either from the cache (if available) or by
   * invoking the specified compiler.
   *
   * @param CachingFileCompiler $cache      This method will try to load the compiled code from this cache.
   * @param string              $sourceFile The filesystem path of the source code file.
   * @return mixed The compiled code.
   */
  function loadFromCache (CachingFileCompiler $cache, $sourceFile);

  /**
   * Renders the compiled template.
   *
   * @param mixed        $template The compiled template,or the original source code if the engine does not support
   *                               template compilation. When called from a View, this is guaranteed to be non-null.
   * @param array|object $data     The view model; optional data for use by data binding expressions on the template.
   *                               <p>Note: Matisse components ignore this parameter, as the view model is set by other
   *                               means.
   * @return string The generated output (ex: HTML).
   */
  function render ($template, $data = null);

}
