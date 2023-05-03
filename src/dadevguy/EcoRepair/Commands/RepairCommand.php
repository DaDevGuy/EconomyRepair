<?php

namespace dadevguy\EcoRepair\Commands;

use dadevguy\EcoRepair\Main;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\item\Armor;

use pocketmine\item\Tool;

use pocketmine\player\Player;

use onebone\economyapi\EconomyAPI;

class RepairCommand extends Command

{

    private $main;

    public function __construct(Main $main)

    {

        $this->plugin = $main;

        parent::__construct($this->main->getConfig()->get("repair.command"), $this->main->getConfig()->get("description"), "/repair", [""]);

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)

    {

        if(!$sender instanceof Player)

        {

            $sender->sendMessage("Please Use This Command In-Game!");

        }

        $item = $sender->main->getInventory()->getItem($sender->main->getInventory()->getHeldItemIndex());

        if ($item->isNull()) {

            $sender->sendMessage("Error: This Item Cannot Be Repaired!");

        }

        if(!$item instanceof Tool && $item instanceof Armor)

        {

            $sender->sendMessage("Error: Only Tools And Armours Can Be Repaired!");

        }

        $price = $this->main->getConfig()->get("repair-price");

        if(EconomyAPI::getInstance()->myMoney($sender) <= $price)

        {

            $sender->sendMessage("Error: You Dont Have Enough Money!");

        }

        else

        {

            EconomyAPI::getInstance()->reduceMoney($sender, $price);

            $item->main->setDamage(0);

            $sender->main->getInventory()->setItemInHand($item);

            $sender->sendMessage("Sucess: Item In Hand Has Been Successfully Repaired");

        }

    }

}
