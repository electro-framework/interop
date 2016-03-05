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

  /**
   * Returns the HTTP request being handled.
   *
   * @return ServerRequestInterface
   */
  function getRequest ();

  /**
   * Sets up the model based on information provided on the HTTP request.
   *
   * ><p>**Note:** this does not save the model, you must call {@see saveModel()} after this method if you want to do
   * that.
   *
   * @param ServerRequestInterface $request
   */
  function handleRequest (ServerRequestInterface $request);

  /**
   * Loads a model from the database using the specified id.
   *
   * <p>If the id is `''` or `null`, an empty model is created.
   * ><p>This only works with ORM models.
   *
   * @param string      $modelClass The model's class name.
   * @param string      $modelName  A property name under which to save the loaded model on the controller's model.
   *                                It is a dot-delimited path; if enpty it targets the controller's model itself.
   * @param string|null $id         The primary key value.
   * @return mixed The loaded model.
   */
  function loadModel ($modelClass, $modelName = '', $id = null);

  /**
   * Loads a model from the database using the id specified on the HTTP request URL.
   *
   * <p>If the URL route parameter is empty, an empty model is created.
   * ><p>This only works with ORM models.
   *
   * @param string $modelClass The model's class name.
   * @param string $modelName  A property name under which to save the loaded model on the controller's model.
   *                           It is a dot-delimited path; if enpty it targets the controller's model itself.
   * @param string $routeParam [optional] The parameter name. As a convention, it is usually `id`.
   * @return mixed The loaded model.
   */
  function loadRequested ($modelClass, $modelName = '', $routeParam = 'id');

  /**
   * Merges data into the model.
   *
   * @param array|null $data If `null` nothihg happens.
   * @throws FatalException
   */
  function merge (array $data = null);

  /**
   * Register an event handler for the controller's after-save event.
   *
   * @param callable $task
   */
  function onAfterSave (callable $task);

  /**
   * Register an event handler for the controller's before-save event.
   *
   * @param callable $task
   */
  function onBeforeSave (callable $task);

  /**
   * Registers an extension that will be called whenever {@see handleRequest()} is called.
   *
   * @param string $extensionClass The name of a class implementing {@see ModelControllerExtensionInterface}.
   */
  function registerExtension ($extensionClass);

  /**
   * Save the model on the database.
   *
   * Override this if you need to customize the saving process.
   *
   * @param array $options Driver-specific options.
   * @return bool true if the model was saved.
   */
  function saveModel (array $options = []);

  /**
   * Sets the model instance owned by the controller.
   *
   * @param mixed $data
   */
  function setModel ($data);

}
