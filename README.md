# pschwisow/phergie-irc-plugin-react-puppet

[Phergie](http://github.com/phergie/phergie-irc-bot-react/) plugin that allows a user to effectively speak and act as the bot.

[![Build Status](https://secure.travis-ci.org/pschwisow/phergie-irc-plugin-react-puppet.png?branch=master)](http://travis-ci.org/pschwisow/phergie-irc-plugin-react-puppet)

## Install

The recommended method of installation is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "pschwisow/phergie-irc-plugin-react-puppet": "dev-master"
    }
}
```

See Phergie documentation for more information on
[installing and enabling plugins](https://github.com/phergie/phergie-irc-bot-react/wiki/Usage#plugins).

## Configuration

There is no plug-in specific configuration. Just add the following to the plugins section of your config.php.

```php
new \PSchwisow\Phergie\Plugin\Puppet\Plugin
```

## Tests

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
./vendor/bin/phpunit
```

## License

Released under the BSD License. See `LICENSE`.
