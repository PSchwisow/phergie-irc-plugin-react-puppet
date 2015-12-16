# pschwisow/phergie-irc-plugin-react-puppet

[Phergie](http://github.com/phergie/phergie-irc-bot-react/) plugin that allows a user to effectively speak and act as the bot.

[![Build Status](https://secure.travis-ci.org/PSchwisow/phergie-irc-plugin-react-puppet.png?branch=master)](http://travis-ci.org/PSchwisow/phergie-irc-plugin-react-puppet) [![Code Climate](https://codeclimate.com/github/PSchwisow/phergie-irc-plugin-react-puppet/badges/gpa.svg)](https://codeclimate.com/github/PSchwisow/phergie-irc-plugin-react-puppet) [![Test Coverage](https://codeclimate.com/github/PSchwisow/phergie-irc-plugin-react-puppet/badges/coverage.svg)](https://codeclimate.com/github/PSchwisow/phergie-irc-plugin-react-puppet)

## Install

The recommended method of installation is [through composer](http://getcomposer.org). The command help plug-in is not required, but is recommended (omit it if choose to).

```JSON
{
    "require": {
        "phergie/phergie-irc-plugin-react-commandhelp": "^1",
        "pschwisow/phergie-irc-plugin-react-puppet": "^2"
    }
}
```

See Phergie documentation for more information on
[installing and enabling plugins](https://github.com/phergie/phergie-irc-bot-react/wiki/Usage#plugins).

## Configuration

There is no plug-in specific configuration. The command plug-in is a hard dependency. If you include command help as recommend in the install section, you should also include it here.

```php
return array(
    'plugins' => [
        // dependencies
        new \Phergie\Irc\Plugin\React\Command\Plugin,
        new \Phergie\Irc\Plugin\React\CommandHelp\Plugin, // optional / recommended

        new \PSchwisow\Phergie\Plugin\Puppet\Plugin,
    ]
);
```

## Usage

You can direct the bot either in a channel or by private message.

Private Message Window:
```
PSchwisow: say #phergie I am a bot.
PSchwisow: act #phergie acts like a bot.
PSchwisow: notice #phergie I like bots.
PSchwisow: help say
Phergie: Usage: puppet saying something
Phergie: Instructs the bot to repeat the specified phrase.
```

Channel #phergie:
```
Phergie: I am a bot.
- Phergie acts like a bot.
*Phergie* I like bots.
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
