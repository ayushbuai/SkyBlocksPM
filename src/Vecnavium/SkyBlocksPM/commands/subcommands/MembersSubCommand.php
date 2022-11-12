<?php

declare(strict_types=1);

namespace Vecnavium\SkyBlocksPM\commands\subcommands;

use Vecnavium\SkyBlocksPM\libs\CortexPE\Commando\args\RawStringArgument;
use Vecnavium\SkyBlocksPM\libs\CortexPE\Commando\BaseSubCommand;
use Vecnavium\SkyBlocksPM\SkyBlocksPM;
use Vecnavium\SkyBlocksPM\invites\Invite;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class MembersSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('skyblockspm.members');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $player = SkyBlocksPM::getInstance()->getPlayerManager()->getPlayerByPrefix($sender->getName());
        $skyblock = SkyBlocksPM::getInstance()->getSkyBlockManager()->getSkyBlockByUuid($player->getSkyBlock());
        $sender->sendMessage(SkyBlocksPM::getInstance()->getMessages()->getMessage('members', [
            "{MEMBERS}" => implode(", ", $skyblock->getMembers())
        ]));
    }

}
