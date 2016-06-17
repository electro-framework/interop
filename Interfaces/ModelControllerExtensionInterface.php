<?php
namespace Electro\Interfaces;

interface ModelControllerExtensionInterface
{
  /**
   * A method that will be called whenever {@see ModelControllerInterface::handleRequest()} is called.
   *
   * @param ModelControllerInterface $modelController
   */
  function modelControllerExtension (ModelControllerInterface $modelController);
}
