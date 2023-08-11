# ActuatorMailerBundle

<img src="https://github.com/SymSensor/ActuatorMailerBundle/blob/main/docs/logo.png?raw=true" align="right" width="250"/>

ActuatorMailerBundle extends [ActuatorBundle](https://github.com/SymSensor/ActuatorBundle) by providing health indicator and information collector for the symfony mailer component.

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require symsensor/actuator-mailer-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require symsensor/actuator-mailer-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    SymSensor\ActuatorBundle\SymSensorActuatorMailerBundle::class => ['all' => true],
];
```


## Configuration

The Bundle can be configured with a configuration file named `config/packages/sym_sensor_actuator.yaml`. Following snippet shows the default value for all configurations:

```yaml
sym_sensor_actuator_mailer:
  enabled: true
  transports:
    default:
      service: mailer.default_transport
```


## License

ActuatorBundle is released under the MIT Licence. See the bundled LICENSE file for details.

## Author

Originally developed by [Arkadiusz Kondas](https://twitter.com/ArkadiuszKondas)
