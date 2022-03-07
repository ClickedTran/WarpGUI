<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\libs\muqsit\invmenu\session;

use ClickedTran\WarpGUI\libs\muqsit\invmenu\InvMenu;
use ClickedTran\WarpGUI\libs\muqsit\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		public InvMenu $menu,
		public InvMenuGraphic $graphic
	){}
}