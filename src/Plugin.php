<?php
/**
 * Phergie plugin that allows a user to effectively speak and act as the bot. (https://github.com/PSchwisow/phergie-irc-plugin-react-puppet)
 *
 * @link https://github.com/pschwisow/phergie-irc-plugin-react-puppet for the canonical source repository
 * @copyright Copyright (c) 2014 Patrick Schwisow (https://github.com/PSchwisow/phergie-irc-plugin-react-puppet)
 * @license http://phergie.org/license New BSD License
 * @package PSchwisow\Phergie\Plugin\Puppet
 */

namespace PSchwisow\Phergie\Plugin\Puppet;

use Phergie\Irc\Bot\React\AbstractPlugin;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Plugin\React\Command\CommandEvent as Event;

/**
 * Plugin class.
 *
 * @category PSchwisow
 * @package PSchwisow\Phergie\Plugin\Puppet
 */
class Plugin extends AbstractPlugin
{
    /**
     * Subscribe to events
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'command.say' => 'handleSayCommand',
            'command.act' => 'handleActCommand',
            'command.raw' => 'handleRawCommand',
            'command.say.help' => 'handleSayHelp',
            'command.act.help' => 'handleActHelp',
            'command.raw.help' => 'handleRawHelp',
        );
    }

    /**
     * Say Command
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleSayCommand(Event $event, Queue $queue)
    {
        $params = $event->getCustomParams();
        if (count($params) < 2) {
            $this->handleSayHelp($event, $queue);
        } else {
            $channels = array_shift($params);
            $queue->ircPrivmsg($channels, implode(' ', $params));
        }
    }

    /**
     * Act Command
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleActCommand(Event $event, Queue $queue)
    {
        $params = $event->getCustomParams();
        if (count($params) < 2) {
            $this->handleActHelp($event, $queue);
        } else {
            $channels = array_shift($params);
            $queue->ctcpAction($channels, implode(' ', $params));
        }
    }

    /**
     * Raw Command
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     * @todo implement this command
     */
    public function handleRawCommand(Event $event, Queue $queue)
    {
        $this->handleRawHelp($event, $queue);
    }

    /**
     * Say Command Help
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleSayHelp(Event $event, Queue $queue)
    {
        $this->sendHelpReply($event, $queue, array(
            'Usage: say channel message',
            'channel - comma-separated list of channels/users to send the message to',
            'message - the message to send (all words after this are assumed to be part of message)',
            'Instructs the bot to repeat the specified phrase.',
        ));
    }

    /**
     * Act Command Help
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleActHelp(Event $event, Queue $queue)
    {
        $this->sendHelpReply($event, $queue, array(
            'Usage: act channel message',
            'channel - comma-separated list of channels/users to send the action to',
            'message - the message to include in the action (all words after this are assumed to be part of message)',
            'Instructs the bot to repeat the specified action.',
        ));
    }

    /**
     * Raw Command Help
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleRawHelp(Event $event, Queue $queue)
    {
        $this->sendHelpReply($event, $queue, array(
            'Usage: NOT CURRENTLY IMPLEMENTED',
            'Instructs the bot to repeat a raw command.',
        ));
    }

    /**
     * Responds to a help command.
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     * @param array $messages
     */
    protected function sendHelpReply(Event $event, Queue $queue, array $messages)
    {
        $method = 'irc' . $event->getCommand();
        $target = $event->getSource();
        foreach ($messages as $message) {
            $queue->$method($target, $message);
        }
    }
}
