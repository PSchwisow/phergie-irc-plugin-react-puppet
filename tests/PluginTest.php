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
     * Tests handleSayCommand().
     */
    public function testHandleSayCommand()
    {
        $event = $this->getMockCommandEvent();
        Phake::when($event)->getSource()->thenReturn('#channel');
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');
        $queue = $this->getMockEventQueue();
        $plugin = new Plugin;
        $channels = '#channel1,#channel2';

        Phake::when($event)->getCustomParams()->thenReturn(array($channels));
        $plugin->handleSayCommand($event, $queue);

        Phake::when($event)->getCustomParams()->thenReturn(array($channels, 'some', 'text'));
        $plugin->handleSayCommand($event, $queue);

        Phake::inOrder(
            Phake::verify($queue, Phake::atLeast(1))->ircPrivmsg('#channel', $this->isType('string')),
            Phake::verify($queue)->ircPrivmsg($channels, 'some text')
        );
    }

    /**
     * Tests handleActCommand().
     */
    public function testHandleActCommand()
    {
        $event = $this->getMockCommandEvent();
        Phake::when($event)->getSource()->thenReturn('#channel');
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');
        $queue = $this->getMockEventQueue();
        $plugin = new Plugin;
        $channels = '#channel1,#channel2';

        Phake::when($event)->getCustomParams()->thenReturn(array($channels));
        $plugin->handleActCommand($event, $queue);

        Phake::when($event)->getCustomParams()->thenReturn(array($channels, 'some', 'text'));
        $plugin->handleActCommand($event, $queue);

        Phake::inOrder(
            Phake::verify($queue, Phake::atLeast(1))->ircPrivmsg('#channel', $this->isType('string')),
            Phake::verify($queue)->ctcpAction($channels, 'some text')
        );
    }

    /**
     * Tests handleRawCommand().
     */
    public function testHandleRawCommand()
    {
        $this->markTestIncomplete('Raw command has not yet been implemented.');
        $event = $this->getMockCommandEvent();
        Phake::when($event)->getSource()->thenReturn('#channel');
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');
        $queue = $this->getMockEventQueue();
        $plugin = new Plugin;
        $channels = '#channel1,#channel2';

        Phake::when($event)->getCustomParams()->thenReturn(array($channels));
        $plugin->handleRawCommand($event, $queue);

        Phake::when($event)->getCustomParams()->thenReturn(array($channels, 'some', 'text'));
        $plugin->handleRawCommand($event, $queue);

        Phake::inOrder(
            Phake::verify($queue, Phake::atLeast(1))->ircPrivmsg('#channel', $this->isType('string')),
            Phake::verify($queue)->ctcpAction($channels, 'some text')
        );
    }

    /**
     * Data provider for testHandleHelp().
     *
     * @return array
     */
    public function dataProviderHandleHelp()
    {
        $data = array();

        $methods = array(
            'handleSayHelp',
            'handleActHelp',
            'handleRawHelp',
        );

        foreach ($methods as $method) {
            $data[] = array($method);
        }

        return $data;
    }

    /**
     * Tests handleSayHelp(), handleActHelp(), and handleRawHelp().
     *
     * @param string $method
     * @dataProvider dataProviderHandleHelp
     */
    public function testHandleHelp($method)
    {
        $event = $this->getMockCommandEvent();
        Phake::when($event)->getCustomParams()->thenReturn(array());
        Phake::when($event)->getSource()->thenReturn('#channel');
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');
        $queue = $this->getMockEventQueue();

        $plugin = new Plugin;
        $plugin->$method($event, $queue);

        Phake::verify($queue, Phake::atLeast(1))
            ->ircPrivmsg('#channel', $this->isType('string'));
    }

    /**
     * Tests that getSubscribedEvents() returns an array.
     */
    public function testGetSubscribedEvents()
    {
        $plugin = new Plugin;
        $this->assertInternalType('array', $plugin->getSubscribedEvents());
    }

    /**
     * Returns a mock command event.
     *
     * @return \Phergie\Irc\Plugin\React\Command\CommandEvent
     */
    protected function getMockCommandEvent()
    {
        return Phake::mock('Phergie\Irc\Plugin\React\Command\CommandEvent');
    }

    /**
     * Returns a mock event queue.
     *
     * @return \Phergie\Irc\Bot\React\EventQueueInterface
     */
    protected function getMockEventQueue()
    {
        return Phake::mock('Phergie\Irc\Bot\React\EventQueueInterface');
    }
}
