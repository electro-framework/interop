<?php
namespace Electro\Interfaces;

/**
 * Marks a class as being able to provide module configuration and bootstrapping.
 *
 * > The methods expected for this interface are not declared on the interface itself, as:
 * > - they are optional;
 * > - their signature is variable.
 *
 * You may implement the following methods:
 *
 * <hr>
 *
 * ### void public function boot(...)
 *
 * Allows a module to request services and perform actions upon them, prior to the HTTP request being sento to the
 * HTTP processing pipeline.
 * <p>This is called after all service providers are configured (see `configure()` below) and have already registered
 * their services (see {@see ServiceProviderInterface}). Furthermore, the {@see WebServer} instance is already initialized
 * and the modukes can access the current HTTP request; for instance, a module may conditionally register services
 *
 * > #### Injecting services
 * > This is an injectable method. You can use the injected services to setup additional functionality that is provided
 * > by this provider.
 *
 * <hr>
 *
 * ### void public function configure (ModuleServices $module, ...);
 *
 * Allows a module to configure the module capabilities it provides.
 * <p>This is called after all service providers have registered their services (see {@see ServiceProviderInterface}).
 *
 * > #### Injecting services
 * > This is an injectable method. You should almost always inject a ModuleServices instance; inject other services on
 * > a needed basis.
 */
interface ModuleInterface
{
  /**
   * @return callable function (mixed ...$dependency)
   */
  function boot ();
}
