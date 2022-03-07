## General

| **Plugins** | **WarpGUI** |
| --- | --- |
| **Version** | **1.0.0** |
| **State** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.state/WarpGUI"></a>** |

<br>
✔️ Welcome to WarpGUI, it's a plugin that allows you to navigate using the chest menu ✔️
<br>
<img src="https://github.com/Clickedtran/WarpGUI/blob/main/icon.png"/>
<br>
✔️ The plugin is inspired by the WarpGUI of Minecraft PC ✔️

## Features
- It's a plugin that allows you to navigate using the chest menu
- The plugin is inspired by the WarpGUI of Minecraft PC

<br>

## Credits / Virions Used
- [InvMenu](https://github.com/Muqsit/InvMenu) (Muqsit)

<br>

## Commands
| **Commands** | **Description** | **Aliases** |
| --- | --- | --- |
| **/warpgui** | **WarpGUI Commands** | **/warp** |

<br>

## Permission
- use permission `warpgui.command` to use command /warpgui
- use permission `warpgui.command.help` to use command /warpgui help
- use permission `warpgui.command.setwarp` to use command /warpgui setwarp
- use permission `warpgui.command.deletewarp` to use command /warpgui deletewarp
- use permission `warpgui.command.editwarp` to use command /warpgui editwarp

<br>

## Config

<details>
  <summary>Click to open</summary>

```yaml
---
# WarpGUI config.yml
#    
#    ░██╗░░░░░░░██╗░█████╗░██████╗░██████╗░░██████╗░██╗░░░██╗██╗
#    ░██║░░██╗░░██║██╔══██╗██╔══██╗██╔══██╗██╔════╝░██║░░░██║██║
#    ░╚██╗████╗██╔╝███████║██████╔╝██████╔╝██║░░██╗░██║░░░██║██║
#    ░░████╔═████║░██╔══██║██╔══██╗██╔═══╝░██║░░╚██╗██║░░░██║██║
#    ░░╚██╔╝░╚██╔╝░██║░░██║██║░░██║██║░░░░░╚██████╔╝╚██████╔╝██║
#    ░░░╚═╝░░░╚═╝░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░░░░░╚═════╝░░╚═════╝░╚═╝
#
# Message Teleport To Warp
# Use {warp} to get warp name
msg-teleport: "§aSuccessfully teleport to warp§6 {warp}"

# Menu WarpGUI Name
menu-name: "WarpGUI"
...
```
</details>

---
## For Developer
- You can access to WarpGUI by using ```WarpGUI::getInstance()```
- Create Warp Usage:
```php
$warpname = "Warp1";
$x = $player->getPosition()->getX();
$y = $player->getPosition()->getY();
$z = $player->getPosition()->getZ();
$world = $player->getPosition()->getWorld()->getDisplayName();
WarpGUI::getInstance()->addWarp($warpname, $x, $y, $z, $world);
```
- Remove Warp Usage:
```php
$warpname = "Warp1";
WarpGUI::getInstance()->removeWarp($warpname);
```

<br>

## Install
>- Step 1: Click the `Direct Download` button to download the plugin
>- Step 2: move the file `WarpGUI.phar` into the file `plugins`
>- Step 3: Restart server for plugins to work
