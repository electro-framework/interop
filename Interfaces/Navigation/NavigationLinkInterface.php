<?php
namespace Selenia\Interfaces\Navigation;

use Psr\Http\Message\ServerRequestInterface;
use Selenia\Exceptions\Fault;

interface NavigationLinkInterface extends \IteratorAggregate
{
  /**
   * Returns the computed link address.
   *
   * <p>This is an alias of {@see NavigationLinkInterface::url()}. It is useful for use on databinding expressions
   * on views.
   *
   * @return string It never returns null.
   */
  function __toString ();

  /**
   * Are links to this location enabled?
   *
   * <p>If disabled, the links will be shown but will not be actionable.
   *
   * <p>Default: **`true`**
   *
   * > ##### Dynamic evaluation
   * > Setting this property to a callback will make it dynamic and lazily evaluated.
   * > Reading the property (calling the method without an argument) will invoke the callback and return the resulting
   * > value.
   *
   * @param bool|callable $enabled [optional]
   * @return $this|bool $this if an argument is given, the property's value otherwise.
   */
  function enabled ($enabled = null);

  /**
   * Returns all navigation links that are direct or indirect children of this link.
   * <p>It yields the full navigation tree, starting from this link (but excluding it), flattened into a single
   * iteration.
   * <p>The iteration keys are numeric.
   *
   * @return \Iterator
   * @see links(), getIterator(), getMenu()
   */
  function getDescendants ();

  /**
   * Returns the next level of navigation links, suitable for display on a navigation menu.
   * <p>Only visible links are included.
   * <p>The iteration keys are numeric.
   * > **Note:** recursively iterating each link's `getMenu()` will yield the full navigation tree.
   * > <p>Alternatively, you may use {@see getDescendants()} to flatten the tree into a single iteration.
   *
   * @return \Iterator
   * @see links(), getIterator(), getDescendants()
   */
  function getMenu ();

  /**
   * Rwturns the original URL as it was set on the navigation declaration.
   *
   * @return string
   */
  function getOriginalUrl ();

  /**
   * The menu item's icon.
   *
   * @param string $icon [optional] A space-separated list of CSS class selectors. Ex: 'fa fa-home'
   * @return $this|string $this if an argument is given, the property's value otherwise.
   */
  function icon ($icon = null);

  /**
   * A unique name that identifies the link.
   *
   * <p>The ID allows you to reference the link elsewhere, for instance, when generating URLs for it.
   *
   * <p>Default: **`null`** (no ID)
   *
   * @param string $id [optional]
   * @return $this|string $this if an argument is given, the property's value otherwise.
   * @throws \InvalidArgumentException If any child has a duplicate ID on the current navigation tree.
   */
  function id ($id = null);

  /**
   * Indicates if the link matches the current URL, either totally or partially.
   *
   * <p>It returns `true` if the link is part of the current trail that spans from the navigation root up to the link
   * that corresponds to the current page.
   *
   * ><p>A link can be active even when it's not visible.
   *
   * @return bool
   */
  function isActive ();

  /**
   * Indicates if the link is actually enabled, taking into account `enabled()`, and missing parameters on the URL.
   *
   * @return bool
   * @throws Fault Faults::REQUEST_NOT_SET
   */
  function isActuallyEnabled ();

  /**
   * Indicates if the link is actually visible, taking into account `visible()`, `visibleIfUnavailable()` and missing
   * parameters on the URL.
   *
   * @return bool
   * @throws Fault Faults::REQUEST_NOT_SET
   */
  function isActuallyVisible ();

  /**
   * Indicates if the link matches the current URL totally (i.e. it matches the current page).
   *
   * @return bool
   */
  function isCurrent ();

  /**
   * Indicates if the link is a group pseudo-link that was created by a {@see NavigationInterface::group()} call.
   *
   * @return bool
   */
  function isGroup ();

  /**
   * Indicates if the link is the last active link on the trail.
   *
   * <p>Selected links are usually highlighted on a user interface.
   * <p>They may also be the 'current' link, but they can also be an ancestor if the next active link is not visible.
   *
   * @return bool
   */
  function isSelected ();

  /**
   * This link's navigation map (a map of child links).
   *
   * @param NavigationLinkInterface[]|\Traversable|callable $navigationMap An iterable value.
   * @return $this|NavigationLinkInterface[]|\Traversable|callable         $this if an argument is given, the
   *                                                                       property's value otherwise.
   *                                                                       <p>To iterate the list of links, it is
   *                                                                       advisable to call <kbd>iterator($value)
   *                                                                       </kbd> on the returned instance to make sure
   *                                                                       you get a valid iterator.
   *                                                                       <p>The iteration keys are strings, as the
   *                                                                       value is map.
   * @see getIterator(), getMenu(), getDescendants()
   */
  function links ($navigationMap = null);

  /**
   * Merges a navigation map with this link's map.
   *
   * @param NavigationLinkInterface[]|\Traversable|callable $navigationMap An iterable value.
   * @param bool                                            $prepend       Append or prepend to the existing children
   *                                                                       collection.
   * @return $this
   */
  function merge ($navigationMap, $prepend = false);

  /**
   * The link's parent link or, if this is a root link, the navigation object.
   *
   * @param NavigationLinkInterface|NavigationInterface $parent [optional]
   * @return $this|NavigationLinkInterface $this if an argument is given, the property's value otherwise.
   */
  function parent (NavigationLinkInterface $parent = null);

  /**
   * Similar to {@see Url()}, but it returns the original, unprocessed URL, with all parameter identifiers untouched.
   *
   * @return string
   */
  function rawUrl ();

  /**
   * Associates an HTTP server request with this link, to enable URL parameters resolution.
   *
   * <p>This is only done for the root link of a navigation hierarchy, all other links will read from their
   * parent until a link with a set value is reached.
   *
   * @param ServerRequestInterface $request [optional]
   * @return $this|bool $this if an argument is given, the property's value otherwise.
   */
  function request (ServerRequestInterface $request = null);

  /**
   * For internal use by the {@see NavigationInterface} that manages the link.
   *
   * <p>When building a navigation trail, the navigation instance calls this method for each child on the trail in order
   * to set its state-related properties.
   *
   * @param bool $active
   * @param bool $selected
   * @param bool $current
   * @return mixed
   */
  function setState ($active, $selected, $current);

  /**
   * The page title.
   *
   * <p>It may be displayed:
   * - on the browser's title bar and navigation history;
   * - on menus and navigation breadcrumbs.
   *
   * <p>Default: **`''`** (no title)
   *
   * > ##### Dynamic evaluation
   * > Setting this property to a callback will make it dynamic and lazily evaluated.
   * > Reading the property (calling the method without an argument) will invoke the callback and return the resulting
   * > value.
   *
   * @param string|callable $title [optional]
   * @return $this|string $this if an argument is given, the property's value otherwise.
   */
  function title ($title = null);

  /**
   * The link's full URL or complete URL path.
   *
   * <p>It can be a path relative to the application's base path, an absolute path or a full URL address.
   *
   * <p>Example: **`'admin/users'`** (which is relative to the app's base path)
   *
   * > <p>**Warning:** unlike other link properties, the value read back from this property after it is explicitly set
   * will frequently differ from the set value.
   *
   * <p>If the `url` property is not explicitly set (defaults to `null`), when read, its value is automatically
   * computed
   * from concatenating all URLs (static or dynamic) from all links on the trail that begins on the home/root link and
   * that ends on this link.
   *
   * <p>The computed value is cached when read for the first time, and subsequent reads will return the cached value
   * (unless the final value is `null`, which is not cached).
   *
   * <p>If any link on the trail defines an absolute path or a full URL, it will be used for computing the subsequent
   * links' URLs. If more than one absolute/full URL exist on the trail, the last one overrides previous ones.
   *
   * > ##### Dynamic evaluation
   * > Setting this property to a callback will make it dynamic and lazily evaluated.
   * > Reading the property (calling the method without an argument) will invoke the callback and return the resulting
   * > value.
   *
   * @param string|callable $url [optional]
   * @return $this|string|null $this if an argument is given, the property's value otherwise.
   *                             If null, the link is non-navigable (it has no URL).
   */
  function url ($url = null);

  /**
   * Are links to this location displayed?
   *
   * <p>If `false`, the links will not be shown on menus, but they'll still be shown in navigation breadcrumbs.
   *
   * <p>Default: **`true`**
   *
   * > ##### Dynamic evaluation
   * > Setting this property to a callback will make it dynamic and lazily evaluated.
   * > Reading the property (calling the method without an argument) will invoke the callback and return the resulting
   * > value.
   *
   * @param bool|callable $visible [optional]
   * @return $this|bool $this if an argument is given, the property's value otherwise.
   */
  function visible ($visible = null);

  /**
   * Are links to this location displayed even if the link's URL cannot be generated due to missing route parameters?
   *
   * <p>If `true`, the link will be shown on menus, but it'll be disabled (and greyed out) until the current route
   * provides all the parameters required for generating a valid URL for this link.
   *
   * <p>Enabling this setting can be used to show the user that there are more links available, even if the user cannot
   * select them until an additional selection is performed somehwere on those link's parent page.
   *
   * ###### Example
   *
   * For the following menu:
   *
   * - Authors
   *     - Books
   *     - Publications
   *
   * The children of the `Authors` menu item will only become enabled when the user selects an author on the `Authors`
   * page and the corresponding author ID becomes available on the URL.
   *
   * <p>Default: **`false`**
   *
   * @param bool $visible [optional]
   * @return $this|bool $this if an argument is given, the property's value otherwise.
   */
  function visibleIfUnavailable ($visible = null);

}
