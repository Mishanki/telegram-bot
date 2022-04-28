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

use app\core\Bot;
use app\helper\KeyboardHelper;
use app\services\SensorPm1Service;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class Pm1Command extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'pm1';

    /**
     * @var string
     */
    protected $description = 'PM1 command';

    /**
     * @var string
     */
    protected $usage = '/pm1';

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
        /* @var $service SensorPm1Service */
        $service = Bot::$container->get(SensorPm1Service::class);

        return $this->replyToChat(
            $service->getMessage(),
            [
                'parse_mode' => 'markdown',
                'reply_markup' => KeyboardHelper::getKeyboard(),
            ]
        );
    }
}