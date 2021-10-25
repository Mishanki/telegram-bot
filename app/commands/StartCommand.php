<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Start command
 *
 * Gets executed when a user first starts using the bot.
 *
 * When using deep-linking, the parameter can be accessed by getting the command text.
 *
 * @see https://core.telegram.org/bots#deep-linking
 */

namespace app\commands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class StartCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start command';

    /**
     * @var string
     */
    protected $usage = '/start';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        // If you use deep-linking, get the parameter like this:
        // $deep_linking_parameter = $this->getMessage()->getText(true);
        return $this->replyToChat(
            'Мониторинг воздуха' . PHP_EOL . PHP_EOL .
            file_get_contents('app/tpl/footer'),
            [
                'parse_mode' => 'markdown',
//                'reply_markup' => json_encode([
//                    'inline_keyboard' => [
//                        [
//                            ['text' => 'pm', 'url' => '/pm'],
//                            ['text' => 'pm1', 'url' => '/pm1'],
//                            ['text' => 'pm24', 'url' => '/pm24'],
//                            ['text' => 'weather', 'url' => '/weather'],
//                        ]
//                    ]
//                ])
            ]
        );
    }
}