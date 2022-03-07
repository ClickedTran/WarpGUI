<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use ClickedTran\WarpGUI\WarpGUI;
use ClickedTran\WarpGUI\gui\GUIManager;

class WarpGUICommands extends Command implements PluginOwned {

    private WarpGUI $plugin;

    public function __construct(WarpGUI $plugin){
    	$this->plugin = $plugin;
    	parent::__construct("warpgui", "WarpGUI Commands", null, ["warp"]);
    	$this->setPermission("warpgui.command");
    }

    public function execute(CommandSender $sender, string $label, array $args){
    	if(!$sender instanceof Player){
    		$sender->sendMessage("§cPlease use command in-game");
    		return true;
    	}
    	if(isset($args[0])){
    		switch($args[0]){
    			case "help":
    			case "?":
    			    if($sender->hasPermission("warpgui.command.help")){
                        $sender->sendMessage("§6> All WarpGUI Commands <");
                        $sender->sendMessage("§b/warpgui help §7- Display all command WarpGUI");
                        $sender->sendMessage("§b/warpgui create §7- Add warp to data");
                        $sender->sendMessage("§b/warpgui remove §7- Remove warp in data");
                        $sender->sendMessage("§b/warpgui edit §7- Edit warp in data");
    			    }else{
                        $sender->sendMessage("§cYou no permission to use this command!");
                    }
    			break;
    			case "create":
                        case "add":
                        case "new":
			case "createwarp":
                        case "addwarp":
                        case "newwarp":
    			    if($sender->hasPermission("warpgui.command.create")){
                        if(!isset($args[1])){
                        	$sender->sendMessage("§cUsage:§7 /warpgui setwarp <warp name>");
                        	return true;
                        }
                        if($this->getOwningPlugin()->warp->exists($args[1])){
                            $sender->sendMessage("§cWarp name $args[1] is already exists !");
                            return true;
                        }
                        $this->getOwningPlugin()->addWarp($args[1]);
                        $sender->sendMessage("§aSuccessfully created warp with name $args[1]");
    			    }else{
                        $sender->sendMessage("§cYou no permission to use this command!");
                    }
    			break;
			case "remove":
			case "delete":
    			case "deletewarp":
                        case "removewarp":
                        case "delwarp":
                        case "rmwarp":
                        case "delete":
                        case "del":
                        case "remove":
                        case "rm":
    			    if($sender->hasPermission("warpgui.command.remove")){
                        if(!isset($args[1])){
                            $sender->sendMessage("§cUsage:§7 /warpgui setwarp <warp name>");
                            return true;
                        }
                        if(!$this->getOwningPlugin()->warp->exists($args[1])){
                            $sender->sendMessage("§cWarp name $args[1] not found !");
                            return true;
                        }
                        $this->getOwningPlugin()->removeWarp($args[1]);
                        $sender->sendMessage("§aSuccessfully removed warp with name $args[1]");
    			    }else{
                        $sender->sendMessage("§cYou no permission to use this command!");
                    }
    			break;
    			case "edit":
                case "setup":
                case "editwarp":
    			    if($sender->hasPermission("warpgui.command.edit")){
                        if(!isset($args[1])){
                            $sender->sendMessage("§cUsage:§7 /warpgui editwarp <warp name>");
                            return true;
                        }
                        if(!$this->getOwningPlugin()->getWarp()->exists($args[1])){
                            $sender->sendMessage("§cWarp name $args[1] not found !");
                            return true;
                        }
                        $this->getOwningPlugin()->editwarp[$sender->getName()] = $args[1];
                        $sender->sendMessage("§6You are in edit mode, usage:");
                        $sender->sendMessage("§l§7help§r§7 - Display available commands");
                        $sender->sendMessage("§l§7done§r§7 - save and leave edit mode");
    			    }else{
                        $sender->sendMessage("§cYou no permission to use this command!");
                    }
    			break;
                case "warp":
                    $gui = new GUIManager();
                    $gui->menuWarpGUI($sender);
                break;
                default:
                    if($sender->hasPermission("warpgui.command.help")){
                        $sender->sendMessage("§cUsage:§7 /warpgui help");
                        $sender->sendMessage("§cIf you want to open the warp menu, use the command:§7 /warpgui warp");
                    }else{
                        $gui = new GUIManager();
                        $gui->menuWarpGUI($sender);
                    }
                break;
    		}
    	}else{
	    if($sender->hasPermission("warpgui.command.help")){
                $sender->sendMessage("§cUsage:§7 /warpgui help");
                $sender->sendMessage("§cIf you want to open the warp menu, use the command:§7 /warpgui warp");
	    }else{
                $gui = new GUIManager();
                $gui->menuWarpGUI($sender);
	    }
	}
    }

    public function getOwningPlugin() : WarpGUI {
        return $this->plugin;
    }
}
