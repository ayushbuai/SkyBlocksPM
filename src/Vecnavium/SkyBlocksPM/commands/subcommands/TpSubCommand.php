<?php

declare(strict_types=1);

namespace Vecnavium\SkyBlocksPM\commands\subcommands;

use pocketmine\Server;
use Vecnavium\SkyBlocksPM\libs\CortexPE\Commando\BaseSubCommand;
use Vecnavium\SkyBlocksPM\SkyBlocksPM;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\Position;

class TpSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('skyblockspm.tp');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) return;

        $skyblock = SkyBlocksPM::getInstance()->getPlayerManager()->getPlayer($sender)->getSkyblock();
        if ($skyblock == '')
        {
            Server::getInstance()->getCommandMap()->dispatch($sender, 'sb create');
            return;
        }
        $spawn = SkyBlocksPM::getInstance()->getSkyBlockManager()->getSkyBlockByUuid($skyblock)->getSpawn();
        $sender->teleport(Position::fromObject($spawn->up(), SkyBlocksPM::getInstance()->getServer()->getWorldManager()->getWorldByName(SkyBlocksPM::getInstance()->getSkyBlockManager()->getSkyBlockByUuid($skyblock)->getWorld())));
    }
}
