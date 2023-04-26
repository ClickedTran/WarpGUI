<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI;

use pocketmine\player\Player;
use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use ClickedTran\WarpGUI\WarpGUI;

class EventListener implements Listener {

    public function __construct(WarpGUI $plugin){
         $this->plugin = $plugin;
    }
  
    public function onChat(PlayerChatEvent $event): void{
		$player = $event->getPlayer();
		if(isset($this->plugin->editwarp[$player->getName()])){
			$event->cancel();
			$args = explode(" ", $event->getMessage());
			$warp = $this->plugin->editwarp[$player->getName()];
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
				    if($this->plugin->getWarp()->exists($warp)){
				        $this->plugin->getWarp()->set($warp, [
                                             "position" => "$x $y $z",
                                             "world" => "$world",
                                             "item" => $this->plugin->getWarp()->get($warp)["item"],
                                             "slot" => $this->plugin->getWarp()->get($warp)["slot"]
		                        ]);
		                $this->plugin->getWarp()->save();
		                $player->sendMessage("§aSuccessfully updated position in X: $x Y: $y Z: $z World: $world");
		            }else{
		            	$player->sendMessage("§cThe warp you are editing no longer exists in the data");
		            }
		        break;
		        case "name":
		            if(!isset($args[1])){
		            	$player->sendMessage("§cUsage:§7 name <name>");
				return true;

		            }
		            if(!$this->plugin->getWarp()->exists($args[1])){
		                $ex = explode(" ", $this->plugin->getPositionWarps($warp));
		                $x = (int)$ex[0];
		                $y = (int)$ex[1];
		                $z = (int)$ex[2];
		                $world = $this->plugin->getWorldWarps($warp);
				$this->plugin->getWarp()->set($args[1], [
                                     "position" => $this->plugin->getWarp()->get($warp)["position"],
                                     "world" => $this->plugin->getWarp()->get($warp)["world"],
                                     "item" => $this->plugin->getWarp()->get($warp)["item"],
                                     "slot" => $this->plugin->getWarp()->get($warp)["slot"]
				]);
				$this->plugin->getWarp()->save();
				$this->plugin->removeWarp($warp);
		                unset($this->plugin->editwarp[$player->getName()]);
		                $this->plugin->editwarp[$player->getName()] = $args[1];
		                $player->sendMessage("§aSuccessfully rename warp to $args[1]");
		            }else{
                                $player->sendMessage("§cWarp name $args[1] is already exists");
		            }
                break;
                case "item":
                    if($player->getInventory()->getItemInHand()->getId() > 0){
                      if($player->getInventory()->getItemInHand() == null){
                        $player->sendMessage("§l§cPlease hold an item in your hand");
                      }else{
                    	$id = $player->getInventory()->getItemInHand()->getId();
                    	$meta = $player->getInventory()->getItemInHand()->getMeta();
                    	$this->plugin->getWarp()->set($warp, [
                            "position" => $this->plugin->getWarp()->get($warp)["position"],
                            "world" => $this->plugin->getWarp()->get($warp)["world"],
                            "item" => $id.":".$meta,
                            "slot" => $this->plugin->getWarp()->get($warp)["slot"]
                    	]);
			      
                        $this->plugin->getWarp()->save();
                    	$player->sendMessage("§aSuccessfully update item warp in gui");
                      }
                    }else{
                    	$player->sendMessage("§cPlease hold an item in your hand");
                    }
      
                break;
                case "slot":
                    if(isset($args[1])){
		                if(!is_numeric($args[1])){
		                	$player->sendMessage("§cUsage:§7 slot <int>");
				
		                }
		                if($args[1] >= 0 || $args[1] <= 53){
		                	$slot = (int)$args[1];
		                    if(!$this->plugin->getWarp()->exists($args[1])){
		                        $this->plugin->getWarp()->set($warp, [
                                             "position" => $this->plugin->getWarp()->get($warp)["position"],
                                             "world" => $this->plugin->getWarp()->get($warp)["world"],
                                             "item" => $this->plugin->getWarp()->get($warp)["item"],
                                             "slot" => $slot
                            	        ]);
					$this->plugin->getWarp()->save();
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
                    if(isset($this->plugin->editwarp[$player->getName()])){
                    	unset($this->plugin->editwarp[$player->getName()]);
                    	$player->sendMessage("§aYou have successfully left edit mode");
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
