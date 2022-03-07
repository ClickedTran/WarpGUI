<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\event;

use pocketmine\event\plugin\PluginEvent;
use ClickedTran\WarpGUI\WarpGUI;

class WarpEvent extends PluginEvent {
    
    /** @var WarpGUI $plugin */
	public WarpGUI $plugin;

	public function __construct(WarpGUI $plugin){
		$this->plugin = $plugin;
	}
}