<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\gui;

use Closure;
use pocketmine\player\Player;
use pocketmine\item\ItemFactory;
use pocketmine\item\StringToItemParser;
use pocketmine\item\LegacyStringToItemParser;
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
		if(count(WarpGUI::getInstance()->getWarp()->getAll()) >= 1){
	        foreach(WarpGUI::getInstance()->getWarp()->getAll() as $warp => $slot){
	        	$name = WarpGUI::getInstance()->getWarp()->getAll()[$warp]["item"];
	        	if(!$inv->getItem(WarpGUI::getInstance()->getWarp()->getAll()[$warp]["slot"])->getTypeId() >= 0){
	        	    $inv->setItem(WarpGUI::getInstance()->getWarp()->getAll()[$warp]["slot"], StringToItemParser::getInstance()->parse($name)->setCustomName((string)$warp)->setLore(["§dWARP:§a $warp \n§eCLICK TO TELEPORT"])->setCount(1));
	        	}
	        }
	    }
	    $menu->send($player);
	}

	public static function menuWarpGUIListener(InvMenuTransaction $transaction) : InvMenuTransactionResult {
        $player = $transaction->getPlayer();
        $action = $transaction->getAction();
        if(WarpGUI::getInstance()->getWarp()->exists($action->getInventory()->getItem($action->getSlot())->getName())){
        	$warp = $action->getInventory()->getItem($action->getSlot())->getName();
            WarpGUI::getInstance()->teleportToWarp($player, $warp);
            $msg = str_replace("{warp}", $warp, WarpGUI::getInstance()->getConfig()->get("msg-teleport"));
            $msg = ($msg != null) ? $msg : "§aSuccessfully teleport to warp§6 {warp}";
            $player->sendMessage($msg);
            return $transaction->discard();
        }
        return $transaction->discard();
	}
}
