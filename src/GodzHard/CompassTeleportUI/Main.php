<?php


namespace GodzHard\CompassTeleportUI;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{

    public $myConfig;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§cPlugin enabled!");
        $this->saveDefaultConfig();
    }

    public function onItem(Player $player) {
        $inventory = $player->getInventory();
        $CompassName = $this->getConfig()->get("CompassName");
        $compass = Item::get(Item::COMPASS, 0, 1)->setCustomName($CompassName);
        $inventory->setItem(4, $compass);
        $inventory->sendContents($player);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $this->onItem($player);
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        if ($player->getLevel()->getFolderName() == $this->getServer()->getDefaultLevel()->getFolderName()) {
            $item = $event->getItem();
            $itemID = $item->getId();
            $action = $event->getAction();
            if ($action == PlayerInteractEvent::RIGHT_CLICK_AIR) {
                switch ($itemID) {
                    case Item::COMPASS:
                        $this->getServer()->dispatchCommand($player, "teleportui");
                        break;
                }
            }
        }
    }

    public function onRespawn(PlayerRespawnEvent $event) {
        $player = $event->getPlayer();
        $this->onItem($player);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        switch ($cmd->getName()) {
            case "teleportui":
                if ($sender instanceof Player) {
                    $this->openMyForm($sender);
                }
        }
        return true;
    }

    public function openMyForm($player) {
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$Title = $this->getConfig()->get("Title");
        $Description = $this->getConfig()->get("Description");

        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
			$ButtonCmd = $this->getConfig()->get("Button-Command");
			$ButtonCmd1 = $this->getConfig()->get("Button1-Command");
			$ButtonCmd2 = $this->getConfig()->get("Button2-Command");
			$ButtonCmd3 = $this->getConfig()->get("Button3-Command");
			$ButtonCmd4 = $this->getConfig()->get("Button4-Command");
			$ButtonCmd5 = $this->getConfig()->get("Button5-Command");
			$ButtonCmd6 = $this->getConfig()->get("Button6-Command");
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd);
                    break;

                case 1:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd1);
                    break;

                case 2:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd2);
                    break;

                case 3:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd3);
                    break;

                case 4:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd4);
                    break;

                case 5:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd5);
                    break;

                case 6:
                    $this->getServer()->dispatchCommand($player, $ButtonCmd6);
                    break;
            }
        });
        $form->setTitle($Title);
        $form->setContent($Description);
		$Button = $this->getConfig()->get("Button");
		$Button1 = $this->getConfig()->get("Button1");
		$Button2 = $this->getConfig()->get("Button2");
		$Button3 = $this->getConfig()->get("Button3");
		$Button4 = $this->getConfig()->get("Button4");
		$Button5 = $this->getConfig()->get("Button5");
		$Button6 = $this->getConfig()->get("Button6");
		$ButtonOn = $this->getConfig()->get("Button-On");
		$Button1On = $this->getConfig()->get("Button1-On");
		$Button2On = $this->getConfig()->get("Button2-On");
		$Button3On = $this->getConfig()->get("Button3-On");
		$Button4On = $this->getConfig()->get("Button4-On");
		$Button5On = $this->getConfig()->get("Button5-On");
		$Button6On = $this->getConfig()->get("Button6-On");

		if ($Button == "true") {
			if ($form->addButton($ButtonOn));
		}
		if ($Button1 == "true") {
			if ($form->addButton($Button1On));
		}
		if ($Button2 == "true") {
			if ($form->addButton($Button2On));
		}
		if ($Button3 == "true") {
			if ($form->addButton($Button3On));
		}
		if ($Button4 == "true") {
			if ($form->addButton($Button4On));
		}
		if ($Button5 == "true") {
			if ($form->addButton($Button5On));
		}
		if ($Button6 == "true") {
			if ($form->addButton($Button6On));
		}
        $form->sendToPlayer($player);
        return $form;
    }

}