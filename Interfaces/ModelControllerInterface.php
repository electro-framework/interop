<?php
namespace Selenia\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Selenia\Exceptions\FatalException;

/**
 * Model controllers automate and encapsulate repetitive model-related tasks that, otherwise, would be redundantly
 * repeated on multiple pages/components.
 *
 * A model controller is a viewless controller that concerns itself mostly with the model layer.
 * It “owns” the model; its primary responsibilities are to mutate the model in response to HTTP requests, validate and
 * parse/transform input data, format data for output and save the model to the database.
 *
 * The model controller is a service shared troughout the application, and its capabilities can be extended via "model
 * controller plugins" (do not confuse with "plugin modules").
 */
interface ModelControllerInterface
{
  /**
   * Returns the model owned by the controller.
   *
   * @return mixed
   */
  function getModel ();

  function handleRequest (ServerRequestInterface $request);

  /**
   * Merges data into the model.
   *
   * @param array|null $data If `null` nothihg happens.
   * @throws FatalException
   */
  function merge (array $data = null);

  function onAfterSave (callable $task);

  function onBeforeSave (callable $task);

  /**
   * @param callable $plugin
   * @return mixed
   */
  function registerPlugin (callable $plugin);

  /**
   * Save the model on the database.
   *
   * Override this if you need to customize the saving process.
   *
   * @return bool true if the model was saved.
   * @throws \Exception
   */
  function saveModel ();

  /**
   * Sets the model instance owned by the controller.
   *
   * @param mixed $data
   */
  function setModel ($data);

}
