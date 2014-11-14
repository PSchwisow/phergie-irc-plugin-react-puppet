<?php
/**
 * Phergie plugin that allows a user to effectively speak and act as the bot. (https://github.com/PSchwisow/phergie-irc-plugin-react-puppet)
 *
 * @link https://github.com/pschwisow/phergie-irc-plugin-react-puppet for the canonical source repository
 * @copyright Copyright (c) 2014 Patrick Schwisow (https://github.com/PSchwisow/phergie-irc-plugin-react-puppet)
 * @license http://phergie.org/license New BSD License
 * @package PSchwisow\Phergie\Plugin\Puppet
 */

namespace PSchwisow\Phergie\Tests\Plugin\Puppet;

use Phake;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Plugin\React\Command\CommandEvent as Event;
use PSchwisow\Phergie\Plugin\Puppet\Plugin;

/**
 * Tests for the Plugin class.
 *
 * @category PSchwisow
 * @package PSchwisow\Phergie\Plugin\Puppet
 */
class PluginTest extends \PHPUnit_Framework_TestCase
{


    /**
     * Tests that getSubscribedEvents() returns an array.
     */
    public function testGetSubscribedEvents()
    {
        $plugin = new Plugin;
        $this->assertInternalType('array', $plugin->getSubscribedEvents());
    }
}
