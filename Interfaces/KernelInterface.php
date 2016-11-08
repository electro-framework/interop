<?php
namespace Electro\Interfaces;

/**
 * The service that loads the bulk of the framework code and the application's modules.
 *
 * <p>Modules should use this service to subscribe to startup events (see the `Electro\Kernel\Services` constants).
 */
interface KernelInterface extends EventSubscriberInterface
{
  /**
   * Loads the kernel, the relevant framework subsystems and all registered plugins and application modules.
   */
  function boot ();

  /**
   * Gets the exit status code that will be returned to the operating system when the program ends.
   *
   * <p>This is only relevant for console applications.
   *
   * @return int 0 if everything went fine, or an error code.
   */
  function getExitCode ();

  /**
   * Returns the active configuration profile.
   *
   * @return ProfileInterface
   */
  function getProfile ();

  /**
   * Registers an event handler for the `CONFIGURE` startup event.
   *
   * <p>Use this event for configuring services.
   *
   * <p>This event type occurs once, during the startup process, to allow modules to make use of services previously
   * registered on the injector to perform configurations/initializations on them.
   *
   * <p>When using the standard {@see WebProfile}, PSR-7 HTTP related objects are already initialized at this stage and
   * a module may inspect the HTTP request to decide if it should boot or not or, for partial booting, which
   * initializations to perform.
   *
   * <p>This event occurs on an order determined by module dependencies, so all services required by a module should be
   * available at the time this event reaches it.
   *
   * ### Notes:
   * > Only initialization/configuration operations should be performed during this phase, other kinds of processing
   * SHOULD be performed later on the processing pipeline.
   *
   * @param callable $handler function (mixed ...$injectableArgs)
   * @return $this Self for chaining.
   */
  function onConfigure (callable $handler);

  /**
   * Registers an event handler for the `PRE_REGISTER` startup event.
   *
   * <p>Use this event for overriding core framework services or when a module needs to perform some action before the
   * main startup process begins and the other modules are initialized.
   *
   * <p>This event type occurs once, during the startup process.
   *
   * <p>This event occurs on an order determined by module dependencies, which means that all the modules required by a
   * given module have already received this event (if they subscribed to it) when that module receives it.
   *
   * ### Notes:
   * >Use this event sparingly.
   *
   * @param callable $handler function (InjectorInterface $injector)
   * @return $this Self for chaining.
   */
  function onPreRegister (callable $handler);

  /**
   * Registers an event handler for the {@see RECONFIGURE} startup event.
   *
   * <p>Use this event for performing additional initialization/configuration steps.
   *
   * <p>This event type occurs once, after all modules are initialized, so all services should have been registered and
   * be available at that time.
   *
   * <p>This event occurs on an order determined by module dependencies, which means that all the modules required by a
   * given module have already received this event (if they subscribed to it) when that module receives it.
   *
   * ### Notes:
   * ><p>Use this event sparingly.</p>
   * ><p>As the `CONFIGURE` event occurs in an order determined by module dependencies, it obviates the need to
   * postpone initialization in most cases.
   *
   * @param callable $handler function (mixed ...$injectableArgs)
   * @return $this Self for chaining.
   */
  function onReconfigure (callable $handler);

  /**
   * Registers an event handler for the `REGISTER_SERVICES` startup event.
   *
   * <p>Use this event for registering a module's services on the injector.
   *
   * <p>When hanling this event, a module SHOULD refrain from doing anything else, both to allow other modules to
   * override the services just registered and to prevent invalid references to services that are not registered yet.
   *
   * ><p>It is a common scenario for a module to register a listener for both this event and the
   * {@see CONFIGURE} event, defining a service on the former and injecting it on the later, giving other modules a
   * chance to override it.</p>
   *
   * ><p>This event type occurs once for all modules, on an order determined by module dependencies, which means that
   * all the modules required by a given module have already received this event (if they subscribed to it) when that
   * module receives it.
   *
   * @param callable $handler function (InjectorInterface $injector)
   * @return $this Self for chaining.
   */
  function onRegisterServices (callable $handler);

  /**
   * Registers an event handler for the `RUN` kernel event.
   *
   * <p>Use this event for performing "useful work" after all module initializations are complete.
   *
   * <p>This event type occurs once, after the startup process, to allow modules to take control of the execution
   * context and do such things as handling an HTTP request or running a console command.
   *
   * <p>This event occurs on an order determined by module dependencies, which means that all the modules required by a
   * given module have already received this event (if they subscribed to it) when that module receives it.
   *
   * ### Notes:
   * > Do not perform service registrations or configurations during this phase.
   *
   * ><p>When using the standard {@see WebProfile}, you do not need to listen to this event for handling HTTP requests,
   * as there is already a service that does it; you should instead register HTTP handlers on the middleware stack or
   * on the router; those handlers will perform your request handling logic.
   *
   * @param callable $handler function (mixed ...$injectableArgs)
   * @return $this Self for chaining.
   */
  function onRun (callable $handler);

  /**
   * Registers an event handler for the `SHUTDOWN` kernel event.
   *
   * <p>Use this event for performing cleanup operations after all "useful work" has been performed and just before the
   * application finishes.
   *
   * <p>This event occurs on an order determined by module dependencies, which means that all the modules required by a
   * given module have already received this event (if they subscribed to it) when that module receives it.
   *
   * ### Notes:
   * > Do not perform service registrations or configurations or any kind of "useful work" during this phase.
   *
   * @param callable $handler function (mixed ...$injectableArgs)
   * @return $this Self for chaining.
   */
  function onShutdown (callable $handler);

  /**
   * Sets the exit status code that will be returned to the operating system when the program ends.
   *
   * <p>This is only relevant for console applications.
   *
   * @param int $code 0 if everything went fine, or an error code.
   * @return void
   */
  function setExitCode ($code);

}
