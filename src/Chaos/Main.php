<?php
namespace Chaos;

use pocketmine\entity\animation\ArmSwingAnimation;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\plugin\PluginBase;


Class Main extends PluginBase implements Listener
{

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }


    public function onDataSend(DataPacketSendEvent $event): void
    {
        $packets = $event->getPackets();
        foreach ($packets as $packet) {
            if ($packet::NETWORK_ID === LevelSoundEventPacket::NETWORK_ID and $packet instanceof LevelSoundEventPacket) {
                if ($packet->sound === LevelSoundEvent::ATTACK_NODAMAGE or $packet->sound === LevelSoundEvent::ATTACK_STRONG) {
                    $event->cancel();
                }
            }
        }
    }

    public function onDataPacketReceive(DataPacketReceiveEvent $event) : void{
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();
        if($player !== null && $packet->pid() === LevelSoundEventPacket::NETWORK_ID && $packet instanceof LevelSoundEventPacket && $packet->sound === LevelSoundEvent::ATTACK_NODAMAGE){
            $player->broadcastAnimation(new ArmSwingAnimation($player));
        }
    }

}

