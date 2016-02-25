<?php
namespace Selenia\Interfaces;

/**
 * A component that can be rendered.
 *
 * <p>It can be any kind of class that outputs markup, it is not restricted to be a Matisse component.
 */
interface RenderableInterface
{
  /**
   * Gets the class name of the context object that the component requires in order to be able to render itself.
   *
   * @return string
   */
  public function getContextClass ();

  /**
   * Renders the component and returns the resulting markup.
   *
   * @return string
   */
  public function getRendering ();

  /**
   * Sets the component's rendering context.
   *
   * <p>This can be called by a router when the component is rendered directly from a route, or by a parent component
   * on a document.
   *
   * > <p>Matisse components require an argument of type {@see Context}.
   *
   * @param mixed $context
   */
  public function setContext ($context);

}
