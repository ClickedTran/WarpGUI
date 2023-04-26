## General

| **Plugins** | **WarpGUI** |
| --- | --- |
| **API** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.api/WarpGUI"></a>** |
| **Version** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.state/WarpGUI"></a>** |
| **Download** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.dl/WarpGUI"></a>** |
| **Total Download** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.dl.total/WarpGUI"></a>** |
<br>


<div align="center">
<img src="https://github.com/Clickedtran/WarpGUI-PM4/blob/Master/icon.png" width="300px" height="auto">
</div>
<br>

✔️ The plugin allows you to create and edit warps ✔️
<br>
✔️ Can add or remove more areas ✔️
<br>

## Features
- It's a plugin that allows you to navigate using the chest menu
- The plugin is inspired by the WarpGUI of Minecraft PC

<br>
<h3>Fixed</h3>

>- Fixed error: ` Do not have in hand`
<br>

## Credits / Virions Used
- [InvMenu](https://github.com/Muqsit/InvMenu) (Muqsit)
- [DEVirion](https://github.com/poggit/devirion) (SOF3)

<br>

## Commands
| **Commands** | **Description** | **Aliases** |
| --- | --- | --- |
| **/warpgui** | **WarpGUI Commands** | **/warp** |

<br>

## Permission

<details> 
  <summary>Click to see permission</summary>

- use permission `warpgui.command` to use command /warpgui
- use permission `warpgui.command.help` to use command /warpgui help
- use permission `warpgui.command.create` to use command /warpgui create
- use permission `warpgui.command.remove` to use command /warpgui remove
- use permission `warpgui.command.edit` to use command /warpgui edit

</details>

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
- You can access to WarpGUI by using 
- You can usage to:
<details>
  <summary>Click to see</summary>

>- Create Warp Usage:

```php
$warpname = "Warp1";
WarpGUI::getInstance()->addWarp($warpname);
```

>- Remove Warp Usage:

```php
$warpname = "Warp1";
WarpGUI::getInstance()->removeWarp($warpname);
```

</details>

<br>

## Tutorial Setup
- [Click Here To See The Tutorial Setup](https://www.youtube.com/watch?v=KRF0pttAR04)
- IMPORTANT THING: You need to install the `DEVirion` plugin into the `plugins/` directory of the server, reload the server, then look for the `virions/` directory, next download and paste the `InvMenu` folder there.

<br>

## Install
>- Step 1: Click the `Direct Download` button to download the plugin
>- Step 2: move the file `WarpGUI.phar` into the file `plugins`
>- Step 3: Restart server

<br>
