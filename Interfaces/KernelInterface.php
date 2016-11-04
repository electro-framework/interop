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
   * <p>This event type occurs once, during the normal startup process, to allow modules to make use of services
   * previously registered on the injector to perform configurations/initializations on them.
   *
   * <p>PSR-7 HTTP related objects are already initialized at this stage and a module may inspect the HTTP request to
   * decide if it should boot or not or, for partial booting, which initializations to perform.
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
   * <p>Use this event for overriding core framework services.
   *
   * <p>This event type occurs once, before the PSR-7 HTTP related objects are initalized, therefore the listeners are
   * able to override the HTTP processing subsystem with their own implementation.
   *
   * <p>The event can also be used when a module needs to perform some action before the main startup process
   * begins and the other modules are initialized.
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
   * ### Notes:
   * ><p>Use this event sparingly.</p>
   * ><p>The `CONFIGURE` event occurs in an order determined by module dependencies, which obviates the need to
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
   * ><p>It is a common scenario for a module to register a listener for both  this event and the
   * {@see CONFIGURE} event, defining a service on the former and injecting it on the later, giving a
   * chance to other modules for overriding it.</p>
   *
   * ><p>This event type occurs once, right after the PSR-7 HTTP related objects are initalized, so modules are able to
   * inspect the HTTP request for deciding what to register.
   *
   * @param callable $handler function (InjectorInterface $injector)
   * @return $this Self for chaining.
   */
  function onRegisterServices (callable $handler);

  /**
   * Loads the kernel, the relevant framework subsystems and all registered plugins and application modules.
   */
  function boot ();

}
