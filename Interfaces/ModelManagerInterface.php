<?php
namespace Selenia\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Selenia\Exceptions\FatalException;

interface ModelManagerInterface
{
  function loadFromRequest (ServerRequestInterface $request);

  /**
   * @param array|null $data If `null` nothihg happens.
   * @throws FatalException
   */
  function merge (array $data = null);

  function onAfterSave (callable $task);

  function onBeforeSave (callable $task);

  /**
   * @param mixed $data
   */
  function setModel ($data);

  /**
   * Save the model on the database.
   *
   * Override if you need to customize the saving process.
   *
   * @return bool true if the model was saved.
   * @throws \Exception
   */
  function saveModel ();

  /**
   * @return mixed
   */
  function getModel ();

}
