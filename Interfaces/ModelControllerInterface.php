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
   * @param string $subModelPath [optional] A property name from which to get the sub-model on the controller's model.
   *                             It is a dot-delimited path; if enpty or ommited, the whole model is returned.
   * @return mixed
   */
  function getModel ($subModelPath = '');

  /**
   * Returns the HTTP request being handled.
   *
   * <p>It must have been set previously with {@see setModel()}, otherwise this returns `null`.
   *
   * @return ServerRequestInterface
   */
  function getRequest ();

  /**
   * Sets up the model based on information provided by the HTTP request.
   *
   * ><p>**Note:** this does not save the model; you must call {@see saveModel()} at some point after calling this
   * method when you want to save the model.
   */
  function handleRequest ();

  /**
   * Loads the whole model or a sub-model from the database using the specified id.
   *
   * <p>Unlike {@see loadModel()}, this does not require an ORM or model class; it simply loads a data array using a
   * query builder or a low level SQL interface.
   *
   * <p>If the id is `''` or `null`, an empty array is created.
   *
   * @param string     $collection    The database table name or collection name.
   * @param string     $subModelPath  A property name under which to save the loaded model on the controller's model.
   *                                  It is a dot-delimited path; if enpty it targets the controller's model itself.
   * @param mixed|null $id            [optional] The primary key value of the record being sought.
   * @param string     $primaryKey    [optional] The table/collection's primary key name. Defaults to `id`.
   * @return mixed The loaded data as an array.
   */
  function loadData ($collection, $subModelPath = '', $id = null, $primaryKey = 'id');

  /**
   * Loads the whole model or a sub-model from the database using the specified id.
   *
   * <p>Unlike {@see loadData()}, this requires a model class, which may be an ORM model.
   *
   * <p>If the id is `''` or `null`, an empty model is created.
   *
   * @param string     $modelClass    The model's class name.
   * @param string     $subModelPath  A property name under which to save the loaded model on the controller's model.
   *                                  It is a dot-delimited path; if enpty it targets the controller's model itself.
   * @param mixed|null $id            The primary key value.
   * @return mixed The loaded model.
   */
  function loadModel ($modelClass, $subModelPath = '', $id = null);

  /**
   * Merges data into the model.
   *
   * @param array|null $data If `null` nothihg happens.
   * @throws FatalException
   */
  function merge (array $data = null);

  /**
   * Register an event handler for performing operations after the model is saved.
   * At that point, the transaction has alread been commited, so no further database operations should be performed.
   * You can, though, do other kinds of cleanup operations, like deleting files, for instance.
   *
   * @param callable $task
   */
  function onAfterSave (callable $task);

  /**
   * Register an event handler for performing operations before the model is saved.
   * At that point, the transaction has not yet began, so no database operations should be performed yet.
   * You can, though, do other kinds of operations, like preparing uploaded files, for instance.
   *
   * @param callable $task
   */
  function onBeforeSave (callable $task);

  /**
   * Register an event handler for saving the model.
   *
   * <p>A model may be a complex entity that requires multiple handlers for saving all of its parts.
   * All handlers registered trough this method run inside the same database transaction and should be responsible for
   * some part of the saving process, or for saving a part of the model.
   * <p>The controller provides a built-in default handler, which tries to save the model automatically.
   * It supports some types of composite models, where they are arrays that contain multiple simple sub-models, or
   * where
   * each sub-model has relationships to other sub-models (for instance, a one-tp-many relationship on an ORM model).
   * <p>Classes implementing this interface will provide varying levels of auto-save functionality, depending on the
   * ORM they support.
   *
   * <p>When `$priority` is positive (+1), the handler will run before previously registered handlers (including the
   * default one).
   * <p>When `$priority` is negative (-1), the handler will run after previously registered handlers (including the
   * default one).
   * <p>When `$priority` is 0, the handler will replace the default one and, supposedly, it will be the main
   * responsible for saving the model.
   *
   * @param int      $priority -1|0|1
   * @param callable $task
   * @return
   */
  function onSave ($priority, callable $task);

  /**
   * Registers an extension that will be called whenever {@see handleRequest()} is called.
   *
   * <p>Extensions usually register event handlers on the controller, so that they'll be invoked later at the
   * appropriate times.
   *
   * > <p>**Note:** extensions are **not** injectable. If you have dependencies on your extensions, use
   * {@see InjectorInterface::makeFactory()} to obtain a registrable callback.
   *
   * @param string|ModelControllerExtensionInterface|callable $extension An instance of, or the name of a class
   *                                                                     implementing (or compatible with)
   *                                                                     {@see ModelControllerExtensionInterface}, or a
   *                                                                     factory closure that returns the instance.
   */
  function registerExtension ($extension);

  /**
   * Saves the whole model on the database.
   *
   * @param array $defaultOptions [optional] Driver/ORM-specific options for the default save handler.
   */
  function saveModel (array $defaultOptions = []);

  /**
   * On composite models, it defines a dot-separated path to the main sub-model.
   *
   * <p>The main sub-model is the target for automatic route parameters merging.
   * <p>If it's an empty string, the whole model is the target.
   *
   * @param string $path
   */
  public function setMainSubModelPath ($path);

  /**
   * Sets the model instance owned by the controller, or a sub-model on it.
   *
   * @param mixed  $data
   * @param string $subModelPath [optional] A property name under which to set the sub-model on the controller's model.
   *                             It is a dot-delimited path; if enpty or ommited it targets the controller's model
   *                             itself.
   */
  function setModel ($data, $subModelPath = '');

  /**
   * Sets the HTTP request that will be handled by {@see handleRequest()}.
   *
   * @param ServerRequestInterface $request
   */
  function setRequest (ServerRequestInterface $request);

  /**
   * Sets the id for subsequent loading operations, using a value specified on the HTTP request URL the matches the
   * given route parameter.
   *
   * <p>Ex:
   * ```
   *   $modelController->withRequestedId('pageId')->loadData('pages');
   *   // or
   *   $modelController->withRequestedId()->loadModel(Page::class);
   * ```
   *
   * <p>In this example, on `loadData` or `loadModel`, you should not specify the `id` argument, as it will be
   * automatically set from the specified (or implicit) route parameter.
   *
   * <p>If the URL route parameter has an empty value, the corresponding empty id will trigger the creation of a new
   * record, for later insertion to the database.
   *
   * @param string $routeParam [optional] The parameter name. If not specified, the usual `id` name is used.
   * @return $this The controller, for chaining.
   */
  function withRequestedId ($routeParam = 'id');

}
