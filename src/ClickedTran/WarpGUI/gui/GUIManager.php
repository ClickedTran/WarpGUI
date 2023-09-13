<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\gui;

use Closure;
use pocketmine\player\Player;
use pocketmine\item\StringToItemParser;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use ClickedTran\WarpGUI\WarpGUI;

class GUIManager {

	public function menuWarpGUI(Player $player){
		$menu = InvMenu::create(InvMenuTypeIds::TYPE_DOUBLE_CHEST);
		$menu->setName(WarpGUI::getInstance()->getConfig()->get("menu-name"));
		$menu->setListener(Closure::fromCallable([$this, "menuWarpGUIListener"]));
		$inv = $menu->getInventory();
		$all_warp = WarpGUI::getInstance()->getWarp()->getAll();
		if(count($all_warp) >= 1){
	        foreach($all_warp as $warp => $slot){
	        	$name = $all_warp[$warp]["item"];
	        	if(!$inv->getItem($all_warp[$warp]["slot"])->getTypeId() >= 0){
	        	    $inv->setItem($all_warp[$warp]["slot"], StringToItemParser::getInstance()->parse($name)->setCustomName((string)$warp)->setLore(["§dWarp:§a $warp \n\n§9§o> Click To Teleport <"])->setCount(1));
	        	}
	        }
	    }
	    $menu->send($player);
	}

	public static function menuWarpGUIListener(InvMenuTransaction $transaction) : InvMenuTransactionResult {
        $player = $transaction->getPlayer();
        $action = $transaction->getAction();
        $plugin = WarpGUI::getInstance();
        if($plugin->getWarp()->exists($action->getInventory()->getItem($action->getSlot())->getName())){
        	$warp = $action->getInventory()->getItem($action->getSlot())->getName();
            $plugin->teleportToWarp($player, $warp);
            $msg = str_replace("{warp}", $warp, $plugin->getConfig()->get("msg-teleport"));
            $msg = ($msg != null) ? $msg : "§9[ §aSuccessfully §9]§r§e You have been teleported to the warp:§6 {warp}";
            $player->sendMessage($msg);
            return $transaction->discard();
        }
        return $transaction->discard();
	}
}
