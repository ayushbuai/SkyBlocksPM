<?php

declare(strict_types=1);

namespace Vecnavium\SkyBlocksPM\invites;

use phuongaz\core\player\PlayerCore;
use Vecnavium\SkyBlocksPM\SkyBlocksPM;
use pocketmine\player\Player;

class Invite
{

    private ?Player $inviter, $receiver;

    public function __construct(Player $inviter, Player $receiver)
    {
        $this->inviter = $inviter;
        $this->receiver = $receiver;
    }

    public function getInviter(): ?Player
    {
        return $this->inviter;
    }

    public function getReceiver(): ?Player
    {
        return $this->receiver;
    }

    public function cancel(): void
    {
        $players = [$this->inviter, $this->receiver];
        foreach ($players as $player)
        {
            if (!$this->inviter instanceof PlayerCore)
                $player->sendMessage(SkyBlocksPM::getInstance()->getMessages()->getMessage('invite-expired'));
        }
    }

    public function handleInvite(): bool
    {
        $inviter = SkyBlocksPM::getInstance()->getPlayerManager()->getPlayerByPrefix($this->inviter->getName());
        $receiver = SkyBlocksPM::getInstance()->getPlayerManager()->getPlayerByPrefix($this->receiver->getName());

        if ($inviter->getSkyBlock() == '' || $receiver->getSkyBlock() == '') {
            var_dump($inviter);
            var_dump($receiver);
        }
        return true;
    }

}
