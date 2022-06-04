<?php

namespace EconomyRepair\DaDevGuy;

use EconomyRepair\DaDevGuy\Commands\RepairCommand;
use pocketmine\plugin\PluginBase;


class Main extends PluginBase
{
    public function onEnable(): void
    {
        $this->getServer()->getCommandMap(new RepairCommand($this));

        if($this->getConfig()->get("config-ver") !== 1)
        {
            $this->getLogger()->info("EconomyRepair! CONFIG Is Not Up To Date Please Delete config.yml and restart the server");
        }
        $this->saveDefaultConfig();
    }
}