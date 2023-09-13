<?php
declare(strict_types=1);
namespace ClickedTran\WarpGUI\commands\subcmds;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;

use ClickedTran\WarpGUI\WarpGUI;

class ListWarpCommand extends BaseSubCommand{
  
  public function prepare(): void{
    $this->setPermission("warpgui.command.list");
  }
  
  public function onRun(CommandSender $sender, String $aliasUsed, Array $args) : void{
    assert($sender instanceof Player);
    $plugin = WarpGUI::getInstance();
    if($plugin->getWarp()->getAll() == null){
      $sender->sendMessage("§o§7Not warp exists in data!");
      return;
    }else{
      $sender->sendMessage("§6> §aAll Warp In Data §6<");
      foreach($plugin->getWarp()->getAll() as $warp => $key){
        $position = $key["position"];
        $item = $key["item"];
        $slot = $key["slot"];
        $world = $key["world"];
      
        $sender->sendMessage("§aWarp: §7".$warp." §ain position §9".$position." §awith item §b".$item." §aat slot §6".$slot." §aat world §7".$world);
      }
    }
  }
}