<?php
/**
 *
 *    _     _           _    _
 *   | \   / |         | |  | |
 *   |  \_/  | ___  ___| |__| |
 *   |       |/ _ \/ __| ___| |
 *   | |\_/| |  __/\__ \ |_ | |
 *   |_|   |_|\___||___/___| \_\
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Mestl <mestl.dev@gmail.com>
 * @link   https://vk.com/themestl
 */

namespace steinssquad\feature\command;


use pocketmine\command\CommandSender;
use steinssquad\steinscore\command\CustomCommand;
use steinssquad\steinscore\player\SteinsPlayer;


class SayCommand extends CustomCommand {

  public function __construct() {
    parent::__construct('say', 'feature', 'steinscore.feature.say');
    $this->registerOverload(['name' => 'message', 'type' => 'message']);
  }

  public function onCommand(CommandSender $sender, array $args): int {
    if (count($args) === 0) return self::RESULT_USAGE;
    $this->broadcast('feature.say-success', ['message' => implode(' ', $args), 'player' => $sender instanceof SteinsPlayer? $sender->getCurrentName(): $sender->getName()]);
    return self::RESULT_SUCCESS;
  }
}