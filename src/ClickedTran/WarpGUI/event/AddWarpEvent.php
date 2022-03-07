<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\event;

use ClickedTran\WarpGUI\event\WarpEvent;
use ClickedTran\WarpGUI\WarpGUI;

class AddWarpEvent extends WarpEvent {
    
    /** @var WarpGUI $plugin */
	public WarpGUI $plugin;

    public $warp;

	public function __construct(WarpGUI $plugin, string $warp){
		$this->plugin = $plugin;
		$this->warp = $warp;
	}

	public function getWarp() : string {
		return $this->warp;
	}
}