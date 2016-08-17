<?php
namespace Electro\Interfaces\DI;

use Auryn\InjectionException;
use Interop\Container\ContainerInterface;

interface InjectorInterface extends ContainerInterface
{
  /**
   * Define an alias for all occurrences of a given typehint
   *
   * Use this method to specify implementation classes for interface and abstract class typehints.
   *
   * @param string $original The typehint to replace
   * @param string $alias    The implementation name
   * @return $this For chaining.
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
   * @return $this For chaining.
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
   * @return $this For chaining.
   */
  function defineParam ($paramName, $value);

  /**
   * Delegate the creation of $name instances to the specified callable
   *
   * @param string $name
   * @param mixed  $callableOrMethodStr Any callable or provisionable invokable method
   * @return $this For chaining.
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
   * Retrieves the mapped class or interface that was set for a given symbolic name.
   *
   * @param string $symbolicName A symbolic (short alias) name previously set on the container.
   * @return string The original mapping to a class or interface.
   */
  public function getMapping ($symbolicName);

  /**
   * Instantiates/provisions a class instance from a class name, interface name or symbolic name.
   *
   * @param string $name A class name, interface name or symbolic name.
   * @param array  $args A map of constructor argument definitions.
   * @return mixed
   * @throws InjectionException If the requested class could not be instantiated.
   */
  public function make ($name, array $args = []);

  /**
   * Instantiate/provision a class instance at a later time.
   *
   * <p>Returns a closure that will instantiate and return the instance when called, without the caller needing to have
   * an instance of the injector.
   *
   * @param string $name A class name, interface name or symbolic name.
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
   * @return $this For chaining.
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
   * Registers a mapping from a symbolic name to a class or interface, or shares an instance under the given symbolic
   * name.
   *
   * <p>This is the same as using the array access operator `[]` for writing, and it is the counterpart to
   * {@see InjectorInterface::get()}.
   *
   * ><p>**Note:** mapping to a class/interface name will not automatically share instances of it; you have to call
   * {@see share()} to do so.
   *
   * @param string $symbolicName   A symbolic (short alias) name.
   * @param string $nameOrInstance A class/interface name or an instance to be shared.
   * @return $this For chaining.
   */
  function set ($symbolicName, $nameOrInstance);

  /**
   * Share the specified class/instance across the Injector context
   *
   * @param mixed       $nameOrInstance The class or object to share.
   * @param string|null $symbolicName   [optional] When set, the class or instance is also saved on the service
   *                                    container under the given symbolic name.
   * @return $this For chaining.
   */
  function share ($nameOrInstance, $symbolicName = null);

}
