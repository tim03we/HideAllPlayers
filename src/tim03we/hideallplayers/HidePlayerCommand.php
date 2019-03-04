<?php

declare(strict_types=1);

namespace tim03we\hideallplayers;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;
use tim03we\hideallplayers\Main;

class HidePlayerCommand extends Command {
	
	public function __construct(Main $plugin) {
		parent::__construct("hideplayers", "Hide Players", "/hideplayers", ["playerhide", "hide"]);
		$this->setPermission("hideplayer.use");
		$this->plugin = $plugin;
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		if(!$this->testPermission($sender)) {
			return false;
		}
		if(!$sender instanceof Player) {
			$sender->sendMessage("Run this Command InGame!");
			return true;
		}
		foreach(Server::getInstance()->getOnlinePlayers() as $players){
            $sender->hidePlayer($players);
        }
        $file = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $sender->sendMessage($file->get("hide-player-message"));
        return false;
    }
}