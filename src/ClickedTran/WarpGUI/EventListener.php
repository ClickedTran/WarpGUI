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
  
    public function onChat(PlayerChatEvent $event) : void{
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
		                $player->sendMessage("§9[ §aSuccessfully §9]§r§e You updated position in X: $x Y: $y Z: $z World: $world");
		            }else{
		            	$player->sendMessage("§9[ §4ERROR §9]§r§c The warp you are editing no longer exists in the data");
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
		           $player->sendMessage("§9[ §aSuccessfully §9]§r§e You have renamed the warp to §7$args[1]");
		           }else{
                                $player->sendMessage("§9[ §4ERROR §9]§r§c Warp name $args[1] is already exists");
		            }
                break;
                case "item":
                  $item = $player->getInventory()->getItemInHand();
                    if($item instanceof ItemBlock && $item instanceof Item){
                    	$name = str_replace([" "], ["_"], strtolower($player->getInventory()->getItemInHand()->getVanillaName()));
                    	WarpGUI::getInstance()->getWarp()->set($warp, [
                            "position" => WarpGUI::getInstance()->getWarp()->get($warp)["position"],
                            "world" => WarpGUI::getInstance()->getWarp()->get($warp)["world"],
                            "item" => $name,
                            "slot" => WarpGUI::getInstance()->getWarp()->get($warp)["slot"]
                    	]);
                        WarpGUI::getInstance()->getWarp()->save();
                    	$player->sendMessage("§9[ §aSuccessfully §9]§r§e You have updated item warp in gui");
			return;
                    }
                break;
                case "slot":
                    if(isset($args[1])){
		                if(!is_numeric($args[1])){
		                	$player->sendMessage("§cUsage:§7 slot <int: 0-53>");
		                	return;
		                }
		                if($args[1] >= 0 || $args[1] <= 53){
		                	$slot = (int)$args[1];
		                	$all_warp = WarpGUI::getInstance()->getWarp()->getAll();
		                	foreach($all_warp as $data => $key){
		                	  if(!$args[1] === $all_warp[$data]["slot"]){
		                	    $player->sendMessage("§9[ §4ERROR §9]§r§c That slot already exists, please try again");
		                	    return;
		                	  }else{
		                    WarpGUI::getInstance()->getWarp()->set($warp, [
                                             "position" => WarpGUI::getInstance()->getWarp()->get($warp)["position"],
                                             "world" => WarpGUI::getInstance()->getWarp()->get($warp)["world"],
                                             "item" => WarpGUI::getInstance()->getWarp()->get($warp)["item"],
                                             "slot" => $slot
                            	        ]);
				            	WarpGUI::getInstance()->getWarp()->save();
		                        $player->sendMessage("§9[ §aSuccessfully §9]§r§e You have updated slot item in warp to $slot");
		                        return;
		                	  }
		              	  }
		                }else{
		                    $player->sendMessage("§9[ §4ERROR §9]§r§c The number you enter can only be entered from 0 -> 53");
		                  return;
		                }
		            }else{
		            	$player->sendMessage("§cUsage:§7 slot <int: 0-53>");
		            	return;
		            }
                break;
                case "done":
                 if(WarpGUI::getInstance()->getWarp()->get($warp)["item"] == "air"){
                    $player->sendMessage("§9[ §4ERROR §9]§r§c The item you setup is air. Please setup again!");
                    return;
                 }
                 if((WarpGUI::getInstance()->getWarp()->get($warp)["position"] == null) or (WarpGUI::getInstance()->getWarp()->get($warp)["item"] == null) or (WarpGUI::getInstance()->getWarp()->get($warp)["slot"] == "")){
                    $player->sendMessage("§9[ §4ERROR §9]§r§c Maybe you haven't set up: §b<position | item | slot>. §cPlease check and try again!");
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
