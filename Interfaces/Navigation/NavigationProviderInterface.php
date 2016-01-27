<?php
namespace Selenia\Interfaces\Navigation;

/**
 * Marks a class as being able to provide navigation information for the application.
 */
interface NavigationProviderInterface
{
  /**
   * Defines a navigation map for the module.
   *
   * ##### Navigation Maps
   *
   * A navigation map is an array of `URL => NavigationLinkInterface` mappings.
   *
   * <p>Array keys are URLs that can be specified on three formats:
   * 1. relative URL paths (ex: `some/path`)
   * 2. absolute URL paths (ex: `/some/path`)
   * 3. full URLs (ex: `http://domain.com/some/path`)
   *
   * Absolute URL paths are always translated to paths relative to the application's base URL.<br>
   * If you do need a real absolute path, you must use the full URL format.
   *
   * @param NavigationInterface $navigation Use this service to generate links, assemble the navigation map and register
   *                                        it on the global navigation registry.
   */
  function defineNavigation (NavigationInterface $navigation);
}
