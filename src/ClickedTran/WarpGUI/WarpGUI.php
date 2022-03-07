<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use ClickedTran\WarpGUI\libs\muqsit\invmenu\InvMenuHandler;
use ClickedTran\WarpGUI\commands\WarpGUICommands;
use ClickedTran\WarpGUI\event\AddWarpEvent;
use ClickedTran\WarpGUI\event\RemoveWarpEvent;
use ClickedTran\WarpGUI\event\TeleportWarpEvent;

class WarpGUI extends PluginBase implements Listener {

	public $editwarp = [];
        
	/** @var WarpGUI */
	public static $instance;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->saveDefaultConfig();
		$this->saveResource("warp.yml");
		$this->warp = new Config($this->getDataFolder() . "warp.yml", Config::YAML);
		$this->getServer()->getCommandMap()->register("WarpGUI", new WarpGUICommands($this));
		self::$instance = $this;
		if(!InvMenuHandler::isRegistered()){
	            InvMenuHandler::register($this);
                }
	}

	public function getWarp(){
                return $this->warp;
	}

	public function onDisable() : void {
		$this->getWarp()->save();
	}
        
        /**
        * @param string $name
        */
	public function addWarp(string $name){
		$this->getWarp()->set($name, [
                "position" => [],
                "world" => [],
                "item" => [],
                "slot" => []
		]);
		$this->getWarp()->save();
		(new AddWarpEvent($this, $name))->call();
	}
        
	/**
        * @param string $name
        */
	public function removeWarp(string $name){
		$all = $this->getWarp()->getAll();
		unset($all[$name]);
		$this->getWarp()->setAll($all);
		$this->getWarp()->save();
		(new RemoveWarpEvent($this, $name))->call();
	}
        
	/**
        * @param string $name
        */
	public function getPositionWarps(string $name){
		if($this->getWarp()->exists($name)){
		        $position = $this->getWarp()->get($name)["position"];
		        return $position;
		}
	}
        
	/**
        * @param string $name
        */
	public function getWorldWarps(string $name){
		if($this->getWarp()->exists($name)){
		        $world = $this->getWarp()->get($name)["world"];
		        $worlds = $this->getServer()->getWorldManager()->getWorldByName($world);
		        return $worlds;
		}
	}
        
	/**
        * @param string $name
        */
	public function getIdItemWarps(string $name){
		if($this->getWarp()->exists($name)){
			$ex = explode(":", $this->getWarp()->get($name)["item"]);
		        $id = (int)$ex[0];
		        return $id;
		}
	}
        
	/**
        * @param string $name
        */
	public function getMetaItemWarps(string $name){
		if($this->getWarp()->exists($name)){
			$ex = explode(":", $this->getWarp()->get($name)["item"]);
		        $meta = (int)$ex[1];
		        return $meta;
		}
	}
        
	/**
        * @param Player $player
        * @param string $name
        */
	public function teleportToWarp(Player $player, string $name){
		if($this->getWarp()->exists($name)){
			if($player instanceof Player){
				$ex = explode(" ", $pos = $this->getPositionWarps($name));
				$world = $this->getWorldWarps($name);
				$x = (int)$ex[0];
				$y = (int)$ex[1];
				$z = (int)$ex[2];
				$player->teleport(new Position($x, $y, $z, $world));
				(new TeleportWarpEvent($this, $player, $name))->call();
			}
		}
	}
}
