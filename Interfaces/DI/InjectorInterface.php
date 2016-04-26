<?php
namespace Selenia\Interfaces\DI;

interface InjectorInterface
{
  /**
   * Define an alias for all occurrences of a given typehint
   *
   * Use this method to specify implementation classes for interface and abstract class typehints.
   *
   * @param string $original The typehint to replace
   * @param string $alias    The implementation name
   * @return $this
   */
  function alias ($original, $alias);

  /**
   * Provision an Executable instance from any valid callable or class::method string
   *
   * @param mixed $callableOrMethodStr A valid PHP callable or a provisionable ClassName::methodName string
   * @return \Auryn\Executable
   */
  function buildExecutable ($callableOrMethodStr);

  /**
   * Define instantiation directives for the specified class
   *
   * @param string $name The class (or alias) whose constructor arguments we wish to define
   * @param array  $args An array mapping parameter names to values/instructions
   * @return $this
   */
  function define ($name, array $args);

  /**
   * Assign a global default value for all parameters named $paramName
   *
   * Global parameter definitions are only used for parameters with no typehint, pre-defined or
   * call-time definition.
   *
   * @param string $paramName The parameter name for which this value applies
   * @param mixed  $value     The value to inject for this parameter name
   * @return $this
   */
  function defineParam ($paramName, $value);

  /**
   * Delegate the creation of $name instances to the specified callable
   *
   * @param string $name
   * @param mixed  $callableOrMethodStr Any callable or provisionable invokable method
   * @return $this
   */
  function delegate ($name, $callableOrMethodStr);

  /**
   * Invoke the specified callable or class::method string, provisioning dependencies along the way
   *
   * @param mixed $callableOrMethodStr A valid PHP callable or a provisionable ClassName::methodName string
   * @param array $args                Optional array specifying params with which to invoke the provisioned callable
   * @throws \Auryn\InjectionException
   * @return mixed Returns the invocation result returned from calling the generated executable
   */
  function execute ($callableOrMethodStr, array $args = []);

  /**
   * Returns the service container instance associated with the ibjector.
   *
   * @return ServiceContainerInterface
   */
  function getContainer ();

  /**
   * Instantiate/provision a class instance
   *
   * @param string $name
   * @param array  $args
   * @return mixed
   */
  public function make ($name, array $args = []);

  /**
   * Instantiate/provision a class instance at a later time.
   *
   * <p>Returns a closure that will instantiate and return the instance when called, without the caller needing to have
   * an instance of the injector.
   *
   * @param string $name
   * @param array  $args The same as {@see make}'s $args.
   * @return mixed
   */
  public function makeFactory ($name, array $args = []);

  /**
   * Register a prepare callable to modify/prepare objects of type $name after instantiation
   *
   * Any callable or provisionable invokable may be specified. Preparers are passed two
   * arguments: the instantiated object to be mutated and the current Injector instance.
   *
   * @param string $name                A class/interface name.
   * @param mixed  $callableOrMethodStr Any callable or provisionable invokable method.
   * @return $this
   */
  function prepare ($name, $callableOrMethodStr);

  /**
   * Checks if a specific alias, delegate or shared instance has been registered on the injector.
   *
   * @param string $name A class/interface name.
   * @return bool True if the class or alias is defined.
   */
  function provides ($name);

  /**
   * @param string $typeName     A class/interface name.
   * @param string $symbolicName Also registers the class or instance on the service container under the given
   *                             symbolic name.
   * @return $this
   */
  function register ($typeName, $symbolicName);

  /**
   * Share the specified class/instance across the Injector context
   *
   * @param mixed       $nameOrInstance The class or object to share.
   * @param string|null $symbolicName   [optional] Also registers the class or instance on the service container under
   *                                    the given symbolic name.
   * @return $this
   */
  function share ($nameOrInstance, $symbolicName = null);

}
