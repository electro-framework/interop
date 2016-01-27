<?php
namespace Selenia\Interfaces\Navigation;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Represents a set of navigation link trees and provides an API for performing operations on it.
 *
 * <p>It also provides functionality for generating links, menus and breadcrumb navigations.
 *
 * <p>There is, usually, one single instance of this interface for the whole application, unless you need to generate
 * additional menus.
 * <p>Modules may provide their own navigation maps that will be merged into the shared navigation instance.<br>
 * The shared instance will be responsible for generating the application's main menu, links and breadcrumbs.
 *
 * ### Navigation Maps
 *
 * A map is a sequence of key=>value pairs, where the key can be either a subpath (ex: 'admin/users') or a
 * route parameter reference (ex: '&#64;userId'), and the value is a `NavigationLinkInterface` instance.
 * <p>String keys set (or override) the links's `subpath` property.
 * <p>Numeric keys or omitted keys do not change the link's `subpath`. You will need to set the link's `URL` property,
 * otherwise it will become `null`.
 */
interface NavigationInterface extends \IteratorAggregate, \ArrayAccess
{
  /**
   * Returns a set of registered IDs and their corresponding links.
   *
   * <p>IDs are registered automatically when a call to `setId()` is done on a link generated from this instance using
   * {@see link()}.
   *
   * @return NavigationLinkInterface[] A map of ID => NavigationLinkInterface
   */
  function IDs ();

  /**
   * Inserts a navigation map into this navigation.
   *
   * @param NavigationLinkInterface[]|\Traversable|callable $navigationMap An iterable value.
   * @param bool                                            $prepend       Append or prepend to the existing children
   *                                                                       collection.
   * @param string                                          $targetId      Optional ID of the link where the merge will
   *                                                                       be performed. If not specified, the root
   *                                                                       link will be targeted.
   * @return $this
   * @throws \InvalidArgumentException If the argument is not iterable.
   */
  function add ($navigationMap, $prepend = false, $targetId = null);

  /**
   * Returns the link matches the current URL totally (i.e. it matches the current page).
   *
   * > <p>The current link may be hidden; in that case, it will differ from {@see selectedLink()}.
   *
   * @return NavigationLinkInterface|null null if not found.
   */
  function currentLink ();

  /**
   * Returns a linear sequence of {@see NavigationLinkInterface} objects that represents the path to the currently
   * displayed page starting from a root (home) link.
   *
   * > <p>All objects on the path come from the navigation tree; these are not clones.
   *
   * @param int $offset If specified, discards the first N items.
   * @return $this|NavigationLinkInterface[]
   */
  function getCurrentTrail ($offset = 0);

  /**
   * Returns the first level of navigation links, suitable for display on a navigation menu.
   * Recursively iterating each link's `getMenu()` will yield the full navigation tree.
   *
   * @return \Iterator
   */
  function getMenu ();

  /**
   * Returns a linear sequence of {@see NavigationLinkInterface} objects that represents the path to the currently
   * displayed page starting from a root (home) link, **but it consists only of visible links**.
   *
   * <p>The visible trail ends at the last visible link that can be reached from the navigation root, so it may not
   * reach the link that corresponds to the current page.
   *
   * <p>See also {@see getCurrentTrail()}.
   *
   * @return $this|NavigationLinkInterface[]
   */
  function getVisibleTrail ();

  /**
   * Creates a new navigation group object, bound to this Navigation.
   *
   * <p>It can be used to group child links on a menu or to display a organizational pseudo-link on a breadcrumb.
   *
   * <p>A group, when displayed as a hyperlink, has a no-action URL, so the browser does not navigate when the user
   * clicks it.
   *
   * @return NavigationLinkInterface
   */
  function group ();

  /**
   * Creates a new navigation link object, bound to this Navigation.
   *
   * @return NavigationLinkInterface
   */
  function link ();

  /**
   * Provides the Navigation instance with information about the current HTTP request, so that it can generate
   * a navigation that suits the application's current state.
   * > <p>This is for internal use only.
   *
   * @param ServerRequestInterface $request [optional]
   * @return $this|ServerRequestInterface
   */
  function request (ServerRequestInterface $request = null);

  /**
   * The root of the tree of navigation links for this navigation instance.
   *
   * <p>This link is not part of the navigation itself,
   * <p>You do not usually set this property, as a root link will be created automatically and you can just add
   * links to it, or to a specific descendant link.
   *
   * @param NavigationLinkInterface $rootLink [optional] The root of the links tree.
   * @return $this|NavigationLinkInterface
   */
  function rootLink (NavigationLinkInterface $rootLink = null);

  /**
   * Returns the link that corresponds to the currently visible page.
   *
   * > <p>It may be an ancestor of the real link that matches the URL if the later is hidden.
   *
   * @return NavigationLinkInterface|null null if not found.
   */
  function selectedLink ();

}
