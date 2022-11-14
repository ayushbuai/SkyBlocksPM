<?php

declare(strict_types=1);

namespace Vecnavium\SkyBlocksPM\commands\subcommands;

use pocketmine\Server;
use pocketmine\utils\TextFormat;
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
        if($skyblock->getLeader() !== $sender->getName())
        {
            $sender->sendMessage(TextFormat::colorize("&cBạn không phải là chủ của đảo này!"));
            return;
        }
        if($memberRemove === $skyblock->getLeader())
        {
            $sender->sendMessage(TextFormat::colorize("&cBạn không thể xóa chủ đảo ra khỏi đảo!"));
            return;
        }
        $members = $skyblock->getMembers();
        if(in_array($memberRemove, $members)){
            $key = array_search($memberRemove, $members);
            unset($members[$key]);
            $skyblock->setMembers($members);
            foreach ($skyblock->getMembers() as $member)
            {
                $mbr = SkyBlocksPM::getInstance()->getServer()->getPlayerByPrefix($member);
                if ($mbr instanceof Player){
                    $mbr->sendMessage(TextFormat::colorize("Đã xóa thành viên &e$memberRemove &rkhỏi hòn đảo của ". $skyblock->getLeader()));
                }
            }
            if(Server::getInstance()->getPlayerByPrefix($memberRemove) instanceof Player){
                $mbr = Server::getInstance()->getPlayerByPrefix($memberRemove);
                $mbr->sendMessage(TextFormat::colorize("Bạn đã bị xóa khỏi hòn đảo của &e". $skyblock->getLeader()));
            }
        }else {
            $sender->sendMessage(TextFormat::colorize("&cThành viên này không tồn tại trong đảo của bạn!"));
        }
    }

}
