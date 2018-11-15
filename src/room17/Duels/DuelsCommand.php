<?php
/**
 *  _____    ____    ____   __  __  __  ______
 * |  __ \  / __ \  / __ \ |  \/  |/_ ||____  |
 * | |__) || |  | || |  | || \  / | | |    / /
 * |  _  / | |  | || |  | || |\/| | | |   / /
 * | | \ \ | |__| || |__| || |  | | | |  / /
 * |_|  \_\ \____/  \____/ |_|  |_| |_| /_/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace room17\Duels;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use room17\Duels\session\Session;

class DuelsCommand extends Command {
    
    /** @var Duels */
    private $loader;
    
    /**
     * DuelsCommand constructor.
     * @param Duels $loader
     */
    public function __construct(Duels $loader) {
        $this->loader = $loader;
        parent::__construct("duels", "Duels main command", "/duel <invite/accept/deny> [player]", [
            "duel",
            "battle"
        ]);
    }
    
    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!$sender instanceof Player) {
            $sender->sendMessage("Please, run this command in game!");
            return;
        }
        $session = $this->loader->getSessionManager()->getSession($sender);
        switch(strtolower($args[0] ?? "usage")) {
            case "invite":
                $playerSession = $this->loader->getSessionManager()->getSessionByName($args[1] ?? "");
                if(!isset($args[1]) or !($playerSession instanceof Session)) {
                    $session->sendLocalizedMessage("NOT_AN_ONLINE_PLAYER", [
                        "name" => $args[1]
                    ]);
                    return;
                }
                 break;
            case "accept":
                break;
            case "deny":
                break;
            case "usage":
            case "help":
                $session->sendLocalizedMessage("HOW_TO_USE_DUELS");
                break;
            case "about":
                $session->getOwner()->sendMessage("Duels {$this->loader->getDescription()->getVersion()} is an open source plugin made by room17 (@GiantQuartz)");
                break;
            default:
        }
    }
    
}