<?php

declare(strict_types=1);

namespace Vecnavium\SkyBlocksPM\commands\subcommands;

use Vecnavium\SkyBlocksPM\libs\CortexPE\Commando\args\RawStringArgument;
use Vecnavium\SkyBlocksPM\libs\CortexPE\Commando\BaseSubCommand;
use Vecnavium\SkyBlocksPM\SkyBlocksPM;
use Vecnavium\SkyBlocksPM\invites\Invite;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class RemoveSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('skyblockspm.remove');
        $this->registerArgument(0, new RawStringArgument('name'));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $memberRemove = $args['name'];

        $player = SkyBlocksPM::getInstance()->getPlayerManager()->getPlayerByPrefix($sender->getName());
        $skyblock = SkyBlocksPM::getInstance()->getSkyBlockManager()->getSkyBlockByUuid($player->getSkyBlock());
        $members = $skyblock->getMembers();
        $members[] = $sender->getName();
        if(isset($members[$memberRemove])){
            unset($members[$memberRemove]);
            $skyblock->setMembers($members);
            foreach ($skyblock->getMembers() as $member)
            {
                $mbr = SkyBlocksPM::getInstance()->getServer()->getPlayerByPrefix($member);
                if ($mbr instanceof Player){
                    $mbr->sendMessage(SkyBlocksPM::getInstance()->getMessages()->getMessage('remove-member', [
                        "{PLAYER}" => $sender->getName()
                    ]));
                }
            }
        }else {
            $sender->sendMessage(SkyBlocksPM::getInstance()->getMessages()->getMessage('member-not-found', [
                "{PLAYER}" => $memberRemove
            ]));
        }
    }

}
