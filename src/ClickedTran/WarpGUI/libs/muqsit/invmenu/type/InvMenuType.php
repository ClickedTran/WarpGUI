<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\libs\muqsit\invmenu\type;

use ClickedTran\WarpGUI\libs\muqsit\invmenu\InvMenu;
use ClickedTran\WarpGUI\libs\muqsit\invmenu\type\graphic\InvMenuGraphic;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

interface InvMenuType{

	public function createGraphic(InvMenu $menu, Player $player) : ?InvMenuGraphic;

	public function createInventory() : Inventory;
}