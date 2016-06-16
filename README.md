# interop
Electro Framework's Interoperability API

### Synopsis

The `interop` package contains shared API code constructs that enable packages developed for use with the Electro framework to work outside of it and be integrated into any other framework or application, as long as a minimum required implementation (or adapter) of the interoperability interfaces is provided.

Not all interfaces need to be implemented for a specific package, you only have to provide an implementation for those actually used by it.

> Of course, the Electro framework provides implementations for all the interop. interfaces.

### Package contents

Besides the common interfaces, this package also provides implementations of some lightweight classes and traits that are framework-independent and shared between pacakges.

#### Available API types

- Interfaces
- Traits
- Exceptions
- Faults
  *(a special kind of exceptions)*

### Documentation

For more information about this API, please refer to the [framework's documentation](http://electro-framework.github.io).

## License

The Electro framework is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT).

**Electro framework** - Copyright &copy; Cláudio Silva and Impactwave, Lda.

