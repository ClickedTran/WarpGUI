<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI;

use pocketmine\player\Player;
use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\item\{Item, ItemBlock};
use pocketmine\block\BlockTypeIds;
use pocketmine\event\player\PlayerChatEvent;

use ClickedTran\WarpGUI\WarpGUI;


class EventListener implements Listener {
    public $plugin;
    public function __construct(WarpGUI $plugin){
         $this->plugin = $plugin;
    }
  
    public function onChat(PlayerChatEvent $event){
		$player = $event->getPlayer();
		if(isset(WarpGUI::getInstance()->editwarp[$player->getName()])){
			$event->cancel();
			$args = explode(" ", $event->getMessage());
			$warp = WarpGUI::getInstance()->editwarp[$player->getName()];
			switch($args[0]){
				case "help":
				case "?":
				    $player->sendMessage("§6> All Edit Commands <");
				    $player->sendMessage("§l§7help§r§7 - Display available commands");
				    $player->sendMessage("§l§7position§r§7 - Update the new position warp");
				    $player->sendMessage("§l§7name§r§7 - Update the name warp");
				    $player->sendMessage("§l§7item§r§7 - Update the item in gui warp");
				    $player->sendMessage("§l§7slot§r§7 - Update the slot in gui warp");
				    $player->sendMessage("§l§7done§r§7- Save and leave edit mode");
				break;
				case "position":
				case "location":
				    $x = $player->getPosition()->getX();
				    $y = $player->getPosition()->getY();
				    $z = $player->getPosition()->getZ();
				    $world = $player->getPosition()->getWorld()->getDisplayName();
				    if(WarpGUI::getInstance()->getWarp()->exists($warp)){
				        WarpGUI::getInstance()->getWarp()->set($warp, [
                                             "position" => "$x $y $z",
                                             "world" => "$world",
                                             "item" => WarpGUI::getInstance()->getWarp()->get($warp)["item"],
                                             "slot" => WarpGUI::getInstance()->getWarp()->get($warp)["slot"]
		                        ]);
		                WarpGUI::getInstance()->getWarp()->save();
		                $player->sendMessage("§aSuccessfully updated position in X: $x Y: $y Z: $z World: $world");
		            }else{
		            	$player->sendMessage("§cThe warp you are editing no longer exists in the data");
		            }
		        break;
		        case "name":
		            if(!isset($args[1])){
		            	$player->sendMessage("§cUsage:§7 name <name>");
		            	return;
		            }
		            if(!WarpGUI::getInstance()->getWarp()->exists($args[1])){
		                $ex = explode(" ", WarpGUI::getInstance()->getPositionWarps($warp));
		                $x = (int)$ex[0];
		                $y = (int)$ex[1];
		                $z = (int)$ex[2];
		                $world = WarpGUI::getInstance()->getWorldWarps($warp);
				WarpGUI::getInstance()->getWarp()->set($args[1], [
                                     "position" => WarpGUI::getInstance()->getWarp()->get($warp)["position"],
                                     "world" => WarpGUI::getInstance()->getWarp()->get($warp)["world"],
                                     "item" => WarpGUI::getInstance()->getWarp()->get($warp)["item"],
                                     "slot" => WarpGUI::getInstance()->getWarp()->get($warp)["slot"]
				]);
				WarpGUI::getInstance()->getWarp()->save();
				WarpGUI::getInstance()->removeWarp($warp);
		                unset(WarpGUI::getInstance()->editwarp[$player->getName()]);
		                WarpGUI::getInstance()->editwarp[$player->getName()] = $args[1];
		                $player->sendMessage("§aSuccessfully rename warp to $args[1]");
		            }else{
                                $player->sendMessage("§cWarp name $args[1] is already exists");
		            }
                break;
                case "item":
                  $item = $player->getInventory()->getItemInHand();
                    if($item instanceof ItemBlock or $item instanceof Item){
                    	$name = str_replace([" "], ["_"], strtolower($player->getInventory()->getItemInHand()->getVanillaName()));
                    	WarpGUI::getInstance()->getWarp()->set($warp, [
                            "position" => WarpGUI::getInstance()->getWarp()->get($warp)["position"],
                            "world" => WarpGUI::getInstance()->getWarp()->get($warp)["world"],
                            "item" => $name,
                            "slot" => WarpGUI::getInstance()->getWarp()->get($warp)["slot"]
                    	]);
                        WarpGUI::getInstance()->getWarp()->save();
                    	$player->sendMessage("§aSuccessfully update item warp in gui");
			return;
		    }
                break;
                case "slot":
                    if(isset($args[1])){
		                if(!is_numeric($args[1])){
		                	$player->sendMessage("§cUsage:§7 slot <int>");
		                	return;
		                }
		                if($args[1] >= 0 || $args[1] <= 53){
		                	$slot = (int)$args[1];
		                    if(!WarpGUI::getInstance()->getWarp()->exists($args[1])){
		                        WarpGUI::getInstance()->getWarp()->set($warp, [
                                             "position" => WarpGUI::getInstance()->getWarp()->get($warp)["position"],
                                             "world" => WarpGUI::getInstance()->getWarp()->get($warp)["world"],
                                             "item" => WarpGUI::getInstance()->getWarp()->get($warp)["item"],
                                             "slot" => $slot
                            	        ]);
					WarpGUI::getInstance()->getWarp()->save();
		                        $player->sendMessage("§aSuccessfully update slot item in warp to $slot");
		                    }else{
                                       $player->sendMessage("§cThe warp you are editing no longer exists in the data");
		                    }
		                }else{
		                    $player->sendMessage("§cThe number you enter can only be entered from 0 -> 53");
		                }
		            }else{
		            	$player->sendMessage("§cUsage:§7 slot <int>");
		            }
                break;
                case "done":
                 if(WarpGUI::getInstance()->getWarp()->get($warp)["item"] == "air"){
                    $player->sendMessage("§9[§4!§9]§c The item you setup is air. Please setup again!");
                    return;
                 }
                 if(WarpGUI::getInstance()->getWarp()->get($warp)["position"] == null || WarpGUI::getInstance()->getWarp()->get($warp)["slot"] == null || WarpGUI::getInstance()->getWarp()->get($warp)["item"] == null){
                    $player->sendMessage("§l§9[§4!§9]§c Maybe you haven't set up: §b<position | item | slot>. Please check and try again!");
                 } else {
                    if(isset(WarpGUI::getInstance()->editwarp[$player->getName()])){
                    	unset(WarpGUI::getInstance()->editwarp[$player->getName()]);
                    	$player->sendMessage("§aYou have successfully left edit mode");
                    }
                 }
                break;
                default:
                    $player->sendMessage("§6You are in edit mode, usage:");
                    $player->sendMessage("§l§7help§r§7 - Display available commands");
                    $player->sendMessage("§l§7done§r§7 - Save and leave edit mode");
                break;
	  	}
		}
	}
}
