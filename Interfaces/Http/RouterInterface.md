# RouterInterface

A service that assists in routing an HTTP request to one or more request handlers.
<p>A handler may generate an HTTP response and/or route to other handlers.
<p>The request will traverse a tree of interconnected handlers, until a full HTTP response is generated or the
tree traversal is completed.

> Note that not all nodes on the tree will be visited, as most routes will not match the request's URL.

If the handler tree is exhausted, the router sends the request to the next handler on the application's main
request handling stack.

### A short introduction to Selenia's HTTP handling concepts

Selenia's router has some unique features that set it apart from most other routers out there.  

For instance, it is a **hierarchical** router, while most other routers are linear ones.  
It also allows multiple handlers to handle a request, each one generating a part of the response. This enables advanced
features like *composite responses* and **Turboload** navigation.

To understand the way the router works, it's important to know the main concepts behind the framework's HTTP request
handling. We'll shortly outline them here before proceeding to the details of the routing process. 

#### Request Handlers

Request handlers are a central concept on Selenia's routing (and general HTTP processing).

All routable elements on a routing tree are either route mappings, request handlers or factories that produce handlers.

##### What is a Request Handler?

On many modern frameworks, **middleware** is used for implementing any logic you might stick between the request/response
life cycle that's not necessarily part of your application logic.

For example:

- Adding session support
- Parsing query strings
- Implementing rate-limiting
- Sniffing for bot traffic
- Adding logging
- Parsing JSON sent on the request
- Compressing the response
- Anything else related to the request/response lifecycle

Selenia expands the traditional middleware concept by making your application logic (Controllers or Components) to also be
implemented as middleware-compatible functions (or callable objects).

So, on Selenia, **Request Handlers are a broad concept the applies to anything that processes HTTP requests and generates/modifies
HTTP responses**.

##### What is the relation between Request Handlers and Middleware?

Request handlers and 100% compatible with PSR-7-compatible middleware.

- You can use existing PSR-7-compatible middleware from other projects or frameworks on your Selenia application.
- You can use Selenia middleware on projects based on other frameworks (or even with no framework at all) as long as they
are PSR-7-compatible.

Nevertheless, on Selenia, request handlers are used on broader context than traditional middleware is.
They can be used to implement middleware, of course, but they are also used to implement routers, controllers and
components.

So, unlinke middleware (which only implement *concerns* or *aspects*), request handlers are also used to implement
application-specific logic.

You can assemble middlewares into a **middleware stack**, which is a set of concentric middleware layers.

##### Composing Request Handlers (the Handler Stack)

Traditional middleware is implemented as a decorator pattern: it wraps around the next middleware on a stack and
interceps HTTP requests and responses that flow in and out of it.

Request handlers are composed in a **handler stack**.

Both the request and the response flow from handler to handler on the stack until a response is fully generated.
At that point, the response starts moving backwards on the stack, evenutally being modified along the way, until the
start of the stack is reached, at which point it will be sent to the HTTP client (usually the web browser).

If the request reaches the stack's end without a complete response being generated, the last handler will usually
just send back an `HTTP 404 Not Found` response.

To make the request and the response advance on the stack, each handler **MUST** call the next handler directly, by 
invoking the `$next` argument (the third parameter of a standard/common middleware signature).

If a handler does not specifically invoke the next one, that next handler and all subsequent handlers will not be invoked
for the current request, and the current handler's response (either the function's return value or the function's response
argument) will start immediately moving backwards the path travelled previously trough the stack.

#### The router middleware

Selenia has a main, application-level, request handling stack. At a specific point on that stack, there is a
**routing middleware handler**, also known as a **router**.

The router makes the request/response flow into a parallel tree-like structure of routes, comprised of patterns
and routable elements (where most of them are also request handlers). This will be explained further ahead.

You can picture this as a tree-like structure whose root is attached to a point in the linear request handling
stack. The request/response must flow trought that tree before returning to the main stack, where it may resume
traveling forward (if there is no complete response to send back) or it may turn back and send the generated response
backwards for eventual further processing and output to the HTTP client.

Now, let's talk about routing.

### Routables

A routable is a term that designates a set of types that are allowed to be used as routing nodes in a routing tree,
trough whom the request will travel, and that are interpreted in a type-specific way by the router.

A given routable can be one of these concrete types:

- a `Traversable` object
- an `array`
- an invokable class name
- a `callable` (object, method or function)
- a *generator* function

Each of these types are interpreted by the router as explained further below.

### Routes

> **Route:** a rule for contitionally sending the request to a routable that branches from the current handler stack.

A route is implemented as a routable that is comprised of a routing pattern and an associated target routable (which may,
in turn, connect to other routables in a tree-like structure).

The branching depends on applying the pattern to the current request URL path.

> If a routable handles the request irrespective of its URL, it is called a **middleware** and not a route.

A route is defined by either calling the router's `route()` method and passing it an iterable routable as argument, or 
indirectly as a child of another routable, somewhere on a hierarchy of interconnected routes.

### Routable Types

#### Iterable routables

If the routable is of an iterable type (i.e. an array, a `Traversable` or a *generator*), it is a
sequence of key/value pairs that defines routes.

A route is defined by a set of keys and their corresponding values:
- Keys define route matching patterns.
- Values define routables that will be invoked if the corresponding match succeeds.

The matching patterns are a DSL that will be explained further below.

###### Routing example

    return $router
      ->for ($request, $response, $next)
      ->route (
      [
        MyMiddleware::class,
        'users' => UsersPage::class,
        SomeOtherMiddleware1::class,
        SomeOtherMiddleware2::class,
        'user' =>
          [
            'GET: @id' => function () { ... },
            'POST:' => function () { ... }
          ]
      ]
    );

##### Route iteration order

Routes (with or without keys) are executed in the same order on which they are defined.

Keyless routes, in reality, have auto-assigned, self-incrementing, integer keys.

Therefore, the example above is equivalent to:

    return $router
      ->for ($request, $response, $next)
      ->route (
      [
        0       => MyMiddleware::class,
        'users' => UsersPage::class,
        1       => SomeOtherMiddleware1::class,
        2       => SomeOtherMiddleware2::class,
        'user'  =>
          [
            'GET: @id' => function () { ... },
            'POST:'    => function () { ... }
          ]
      ]
    );

So, the iteration order for the keys is:

- `0`
- `'users'`
- `1`
- `2`
- `'user'`
- `'GET: @id'`
- `'POST:'`

**Important:** integer keys are never matched against the request's URL; their corresponding routables
**always run**.

##### Middleware

The example above highlights a major feature of Selenia's router: **you can mix routables with keys and routables without
keys**, and they'll be executed in order.

As keyless routables always run, they are ideal for implementing traditional **middleware** (like filters, loggers, etc.).

> In fact, an **iterable routable** is quite like a **handler stack**, but keys have special meaning because they are
interpreted by a router, while a handler stack just blindly calls the next handler whenever a handler calls `$next()`. 

If a middleware performs its own routing, it can be considered a **route**.

#### Routables implementing `RequestHandlerInterface` or a compatible callable

A request handler must, of course, implement `RequestHandlerInterface` or a compatible call signature, which is, also,
middleware-compatible.

If a name of a class is given, the router will instantiate that class via dependency-injection
and then invoke it as middleware.

Otherwise, it will invoke the callable directly, supplying the 3 standard middleware arguments:

- the request,
- the response,
- a "next" callable.

The function may declare less parameters, as long as they are declared in that order. The extra arguments will still
be supplied, but they'll be ignored by the called function.

###### Allowable call signatures

    function ($request, $response, $next) {}
    function ($request, $response) {}
    function ($request) {}
    function () {}

You can also type hint the parameters:

    function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {}

###### Example of routes with request handler routables

    $router->route (
      [
        'users' => UsersPage::class,
        
        'user/@id' => function (ServerRequestInteface $request, ResponseInterface $response, callable $next) {
          $id = $request->getAttribute('@id');
          // do something
          return $next ();  // jumps to the next route ('other')
        },
        
        'other' => function () {
          // You can ommit unneeded parameters
        }
      ]
    );

##### Request handlers' execution flow

Handlers (or middleware) are executed sequentally, but only if each Handlers calls the provided "next" argument.

When a Handler does not call the "next" argument, the router immediately returns the response to the previous
route/middleware (even if the curent middleware returns nothing).

Inside a Handler function, the router instance is mutated to reflect the current request and response at the point.
So, you don't need to call `$router->with()`, you can just `use ($router)` on the Handler function.

#### Factory routables

Factories can have any number of arguments and they are dependency-injected when invoked.

You can use them for:

- instantiating an object that implements `RequestHandlerInterface` but that needs
additional configuration to be performed on it before it is invoked;
- instantiating a factory that needs configuration for creating the actual routable instance.

To make the router recognize a function as being a factory, you must wrap it in a `factory()` decorator.

    $router->route (
      [
        'user/@id' => factory (function (UserPage $page) {
          $page->someProperty = value;
          return $page;
        })
      ]
    );

If you do not whish to use the `factory()` global shortcut function, you may instead directly instantiate an instance of
the `RoutableFactory` class.

    $router->route (
      [
        'user/@id' => new FactoryRoutable (function (UserPage $page) {
          ...
        })
      ]
    );

Factories **MUST** return a routable instance (usually the same provided argument, but not always).

If the returned routable is, again, a configurable router, the process is repeated recursively.
 
##### Returning nothing or `null`

If the factory returns nothing (or null), execution proceeds to the next route.

This is different from standard the behaviour of handlers, which when they returns nothing, it's equivalent to returning
the current response. You can't have that here, as factories are not middleare and they do not receive a response instance.

This modified behaviour also allows you to simply run a factory to setup something before matching some additional routes.

### Handling requests

On a middleware where you whish to perform routing, before using the router you must call the `with()` method,
passing it the current request, the current response and the "next" handler.

`with()` will return a the same `RouterInterface` instance, but configured to the given parameters, while pushing the
previous context to stack, from where it can recover it when backtracking from the current routing depth.

You may then call `route()` on the router to perform the routing.

###### Example

    function ($request, $response, $next) {
      return $router
        ->with ($request, $response, $next)
        ->route (...);
    }
    
> **Note:** most other examples on this documentation ommit this setup code, and begin with `$router->route(...)`.
 This is just for the sake of brevity.

A handler (middleware or routable) should do one of the following:

- return a new Response object
- add to the content of the current Response object and return it
- return nothing (it's the same as returning the current Response)
- return the result of calling the "next" argument

A handler should call "next" if it decides to NOT handle the request or if it wants to delegate that handling to
another handler **at the same depth or above it** but still capture the generated response and, eventually, modify it.

Up to this point, it operates in the same fashion as standard middleware.

But routables can also perform sub-routing of the request, by invoking again the router on their request instance.

#### Handling sub-routes

If a routable is not the final routing destination and it needs to delegate processing to sub-routes,
it should return the result of invoking the router again for the desired sub-routes.

###### Example

For the path `user/37/records`:

    $router->route (
      [
        // You are not required to use a callable for a sub-route
        
        'user'   => [
          '@id' => UserPage::class,
        ],
        
        // But you can use one, if you whish
        
        'user' => function () {         // $request, $response and $next can be ommited
          // it may do something here...
          
          return $router->route ([      // sub-routing
            '@id' => UserPage::class,
          ]);
        },
        
        // A more complex and contrived example
        
        'author' => function ($request, $response, $next) {
          $path = $request->getUri ()->getPath ();        // $path == '37/records'
          if (!is_numeric ($path[0])) return $next ();    // give up and proceed to the next route
          return $router->route (
            [
              '@id' => function ($request) {              // you can ommit the remaining params
                $path = $request->getUri ()->getPath ();  // $path == 'records'
                $id = $request->getAttribute ('@id');     // $id == 37
                return "Hello World!";
              }
            ]
          );
        }
      ]
    );

#### Handling errors

Exceptions thrown from a handler will backtrace through the routing tree and throught the handler stack until a handler
catches them with a `try catch` block surrounding its "next" call.

If a handler catches an exception, it can either re-throw it to be catched by a previous handler, or convert it to an
HTTP response that travels back the stack.

> Exception handlers **SHOULD NEVER** suppress exceptions and resume executing the handler stack. 

### Route patterns

Any iterable that exposes a set of keys and values is interpreted as a routing table.  
Each key/value pair is a route.  
Each key is a pattern written in a DSL that instructs the router on how to mach one or more URL path segments.

> There are no patterns for matching other parts of the URL (like the protocol, domain, etc.). You don't need patterns
for that; you can simply define a routable that checks those elements using plain PHP and the request object.

#### DSL syntax

A route pattern has the following syntax:

`[methods ]path`

> **Grammar**

> `[]` encloses optional elements

> `()` groups elements

> `|` separates alternatives

> All other symbol/punctuation characters are themselves.

> Alphabetic characters define a label for a pattern part (ex: `methods`) or character sequence (ex: `literal`).

##### The methods pattern part

It can be one or more of `GET|POST|PUT|DELETE|PATCH|HEAD|OPTIONS` or any other HTTP method.
If not specified, it maches any method. To specify more than one, separate them with `|`.

The pattern part **must** end with a single space.

##### The path pattern part 

It has the following syntax:

`(.|*|literal|@param)[...]`

- an empty path pattern is not allowed; at least on character must be specified. 

- `.` matches an empty URL path, which means either the path is the root path `/` or the path segment matched by the previous
pattern was the final one on the URL.

- `*` matches any path (including an empty path) from that point until the path's end.
  A new request object is generated with its path set to `''`.

- `+` matches any path (excluding an empty path) from that point until the path's end.
  A new request object is generated with its path set to `''`.

- `...` is similar to `*`, but it generates a new request object with a new path that is comprised of all characters
  matched by the dots. 

- `literal` is any literal text. You can use any character excluding the ones reserved for pattern matching.
  You may also use `/` for matching multiple segments.<br>
  A new request object is generated with a new path that has the matched span removed.
  > The matcher assumes there is an implicit `/` at the end of any pattern, but it also matches if the URL
  does not end with `/`.  
  > Ex: `'user/37'` matches `'user/37/records'` and `'user/37'`, but not `'user/371'`

- `@param` matches any character sequence until `/` and saves it as a route parameter with the given name.
  You can retrieve it later via the request object, calling `getAttribute('@param')`.<br>
  A new request object is generated with a new path that has the matched span removed.
  > Ex: when `'user/@id'` matches `'users/3'`, the router sets the route parameter `@id` to the value 3. You can read
    it later by calling `$request->getAttribute('@id')`.
  > <p>**Note:** `@param` also matches and empty path segment, ex: `users/`. The value of the captured parameter
    will be an empty string.
