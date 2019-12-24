<?php

namespace Rendii09\MoreUI;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getLogger()->info(C::GREEN . "Enable! MoreUI telah di aktifkan");
       
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->getResource("config.yml");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED . "Disable! MoreUI telah di nonaktifkan");
    }
        
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "mui":
                if($sender instanceof Player){
                    if($sender->hasPermission("mui.cmd")){
                        $this->openMenu($sender);
                        return true;
                    }else{
                        $sender->sendMessage(C::RED . "Anda tidak memiliki izin untuk menggunakan peeintah ini");
                        return true;
                    }

                }else{
                    $sender->sendMessage(C::RED . "Gunakan perintah ini di dalam game");
                    return true;
                }     
        }
    }
            
    public function openMenu($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $this->FlyUI($sender);
                break;
                case 1:
                    $this->GMUI($sender);
                break;
                case 2:
                    $this->TmSetUI($sender);
                break;
            
                }
            });
            $form->setTitle($this->getConfig()->get("mui.title"));
            $form->setContent($this->getConfig()->get("mui.content"));
            $form->addButton($this->getConfig()->get("mui.flyui"));
            $form->addButton($this->getConfig()->get("mui.gmui"));
            $form->addButton($this->getConfig()->get("mui.tmset"));
            $form->sendToPlayer($sender);
            return $form;
    }

    public function FlyUI($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $sender->sendMessage($this->getConfig()->get("fly.on.msg"));
                    $sender->addTitle("§l§eFly!", "§fDiaktifkan");
                    $sender->setAllowFlight(true);
                break;
                case 1:
                    $sender->sendMessage($this->getConfig()->get("fly.off.msg"));
                    $sender->addTitle("§l§eFly!", "§fNonaktifkan");
                    $sender->setAllowFlight(false);
                break;
                case 2:
                    $this->openMenu($sender);
                break;

                }
            });
            $form->setTitle($this->getConfig()->get("fly.title"));
            $form->setContent($this->getConfig()->get("fly.content"));
            $form->addButton($this->getConfig()->get("fly.on"));
            $form->addButton($this->getConfig()->get("fly.off"));
            $form->addButton($this->getConfig()->get("fly.back"));
            $form->sendToPlayer($sender);
            return $form;
    }
            
    public function GMUI($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $sender->setGamemode(0);
                    $sender->sendMessage("$this->getConfig()->get("gms.on"));
                    $sender->addTitle("§l§eSurvival!", "§fDiaktifkan");
                break;
                case 1:
                    $sender->setGamemode(1);
                    $sender->sendMessage($this->getConfig()->get("gmc.on"));
                    $sender->addTitle("§l§eCreative!", "§fDiaktifkan");
                break;
                case 2:
                    $sender->setGamemode(2);
                    $sender->sendMessage($this->getConfig()->get("gma.on"));
                    $sender->addTitle("§l§eAdventure!", "§fDiaktifkan");
                break;
                case 3:
                    $sender->setGamemode(3);
                    $sender->sendMessage($this->getConfig()->get("gmsp.on"));
                    $sender->addTitle("§l§eSpectactor!", "§fDiaktifkan");
                break;
                case 4:
                    $this->openMenu($sender);
                break;

                }
            });
            $form->setTitle($this->getConfig()->get("gm.title"));
            $form->setContent($this->getConfig()->get("gm.content"));
            $form->addButton($this->getConfig()->get("gms.btn"));
            $form->addButton($this->getConfig()->get("gmc.btn"));
            $form->addButton($this->getConfig()->get("gma.btn"));
            $form->addButton($this->getConfig()->get("gmsp.btn"));
            $form->addButton($this->getConfig()->get("gm.back"));
            $form->sendToPlayer($sender);
            return $form;
    }
            
    public function TmSetUI($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $sender->getLevel()->setTime(0);
                    $sender->sendMessage($this->getConfig()->get("day.time"));
                    $sender->addTitle("§l§eDay!", "§fDiaktifkan");
                break;
                case 1:
                    $sender->getLevel()->setTime(15000);
                    $sender->sendMessage($this->getConfig()->get("night.time"));
                    $sender->addTitle("§l§eNight!", "§fDiaktifkan");
                break;
                case 2:
                    $this->openMenu($sender);
                break;

                }
            });
            $form->setTitle($this->getConfig()->get("tmset.title"));
            $form->setContent($this->getConfig()->get("tmset.content"));
            $form->addButton($this->getConfig()->get("tmset.day"));
            $form->addButton($this->getConfig()->get("tmset.night"));
            $form->addButton($this->getConfig()->get("tmset.back"));
            $form->sendToPlayer($sender);
            return $form;
    }
}
