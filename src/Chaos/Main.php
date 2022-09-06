<?php
namespace Chaos;

use pocketmine\entity\animation\ArmSwingAnimation;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\plugin\PluginBase;


Class Main extends PluginBase implements Listener
{

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDataPacketReceive(DataPacketReceiveEvent $event) : void{
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();
        if($player !== null && $packet->pid() === LevelSoundEventPacket::NETWORK_ID && $packet instanceof LevelSoundEventPacket && $packet->sound === LevelSoundEvent::ATTACK_NODAMAGE){
            $player->broadcastAnimation(new ArmSwingAnimation($player));
        }
    }

}

