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

namespace steinssquad\admin\command\jail;


use pocketmine\command\CommandSender;
use steinssquad\admin\SteinsAdmin;
use steinssquad\perms\SteinsPerms;
use steinssquad\steinscore\command\CustomCommand;
use steinssquad\steinscore\player\SteinsPlayer;


class UnjailCommand extends CustomCommand {

  public function __construct() {
    parent::__construct('unjail', 'admin', 'steinscore.admin.jail');
    $this->registerOverload(['name' => 'player', 'type' => 'player']);
  }

  public function onCommand(CommandSender $sender, array $args): int {
    if (count($args) === 0) return self::RESULT_USAGE;
    $player = SteinsPlayer::getOfflinePlayer(array_shift($args));
    if (!($player instanceof SteinsPlayer) || $player === $sender) return self::RESULT_PLAYER_NOT_FOUND;
    $issuer = ($issuer = SteinsAdmin::$instance->getJailIssuer($player)) !== null ? SteinsPlayer::getOfflinePlayerExact($issuer) : null;
    if ($sender instanceof SteinsPlayer && SteinsPerms::$instance->getGroup($issuer)->getPriority() > $sender->getGroup()->getPriority()) return self::RESULT_PLAYER_HAS_IMMUNITY;
    if (SteinsAdmin::$instance->unjailPlayer($player)) {
      $this->broadcast('admin.unjail-success', ['player' => $sender instanceof SteinsPlayer? $sender->getCurrentName(): $sender->getName(), 'target' => SteinsPlayer::getPlayerName($player)]);
      return self::RESULT_SUCCESS;
    }
    $sender->sendMessage($this->translate('admin.unjail-failed'));
    return self::RESULT_SUCCESS;
  }
}