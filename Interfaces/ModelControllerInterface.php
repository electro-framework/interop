<?php
namespace Electro\Interfaces;

use Electro\Exceptions\FatalException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Model controllers automate and encapsulate repetitive model-related tasks that, otherwise, would be redundantly
 * repeated on multiple pages/components.
 *
 * <p>A model controller is a viewless controller that concerns itself mostly with the model layer.
 * It “owns” the model; its primary responsibilities are to mutate the model in response to HTTP requests, validate and
 * parse/transform input data, format data for output and save the model to the database.
 *
 * <p>The model controller is a service shared throughout the application. Its capabilities can be extended via
 * *model controller extensions* and *event handlers*.
 */
interface ModelControllerInterface
{
  /**
   * Gets a field from the model or from a sub-model.
   *
   * @param string $path A dot delimited path.
   * @return mixed
   */
  function get ($path);

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
   * Parses a property path and returns the target (sub)model and the target simple property identifier.
   *
   * @param string $path A dot delimited path.
   * @return array A touple of (targetModel, targetProperty)
   */
  function getTarget ($path);

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
   * <p>This does not require an ORM or model class; it may simply load a data array using a query builder or a low
   * level SQL interface. In that case, the first argument should be the collection/table name.
   *
   * <p>If the id is `''` or `null`, an empty model is created.
   *
   * @param string     $modelClassOrCollection The model's class name or, if not using an ORM, a collection/table name.
   * @param string     $subModelPath           A property name under which to save the loaded model on the controller's
   *                                           model. It is a dot-delimited path; if empty it targets the controller's
   *                                           model itself.
   * @param mixed|null $id                     The primary key value. If not specified, the value set by
   *                                           {@see withRequestedId} will be used.
   * @param string     $primaryKey             [optional] When not using a model class, this is the table/collection's
   *                                           primary key name. If not specified, the name set by
   *                                           {@see withRequestedId} will be used or, if not set that way, it will
   *                                           default to `id`.
   * @return mixed An instance of the loaded model or the loaded data as an array.
   */
  function loadModel ($modelClassOrCollection, $subModelPath = '', $id = null, $primaryKey = null);

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
   * @param callable $task A handler that receives a single argument of type {@see ModelControllerInterface}.
   */
  function onAfterSave (callable $task);

  /**
   * Register an event handler for performing operations before the model is saved.
   * At that point, the transaction has not yet began, so no database operations should be performed yet.
   * You can, though, do other kinds of operations, like preparing uploaded files, for instance.
   *
   * @param callable $task A handler that receives a single argument of type {@see ModelControllerInterface}.
   */
  function onBeforeSave (callable $task);

  /**
   * Register an event handler for saving the model.
   *
   * <p>A model may be a complex entity that requires multiple handlers for saving all of its parts.
   * <p>All handlers registered trough this method run inside the same database transaction and should be responsible
   * for some part of the saving process, or for saving a part of the model.
   * <p>The controller provides a built-in default handler, which tries to save the model automatically.
   * <p>It supports some types of composite models, whether they are arrays that contain multiple simple sub-models, or
   * each sub-model has relationships to other sub-models (for instance, a one-to-many relationship on an ORM model).
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
   * @param callable $task     A handler that receives a single argument of type {@see ModelControllerInterface}.
   */
  function onSave ($priority, callable $task);

  /**
   * Sets a map/list hybrid of route parameter names to model fields, which will be used to automatically copy route
   * parameter values from the current request to the model's fields.
   *
   * <p>Array items having a numeric key (explicit or implicit) will be interpreted the same way as if an item with both
   * key and value having the same value was specified.
   *
   * ###### Ex:
   *       $model->preset (['id', 'page_id' => 'pageId'])
   * <p>On the previous example, `'id'` is equivalent to `'id' => 'id'`.
   *
   * @param array $presets
   * @return $this The controller, for chaining.
   */
  function preset (array $presets);

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
   * <p>The arguments to a previous {@see loadModel}() call determine the collection(s) and other relevant settings.
   */
  function saveModel ();

  /**
   * Sets a field on the model or on a sub-model.
   *
   * @param string $path A dot delimited path.
   * @param        $value
   */
  function set ($path, $value);

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
   * A dot-separated path to the main model, starting from the view model root.
   *
   * <p>All model fields should have path names beginning with this value as prefix.
   * > <p>Ex: for the default value, which is `'model'`, all model fields should be prefixed with `'model.'`.
   *
   * @param string $path
   */
  public function setModelRootPath ($path);

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
   *   $modelController->withRequestedId('pageId', 'pkey')->loadModel('pages');
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
   * @param string|null $routeParam [optional] The parameter name. If not specified, the usual `id` name is used.
   * @param string|null $primaryKey [optional] The table's primary key field name. If not given,  the value set by
   *                                {@see withRequestedId} will be used, or the model's primary key name will be used
   *                                or 'id' will be assumed.
   * @return $this The controller, for chaining.
   */
  function withRequestedId ($routeParam = 'id', $primaryKey = null);

}
