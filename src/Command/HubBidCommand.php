<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Command;

use App\Services\PersistenceService;
use App\Utils\EntityConfig;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of HubBidCommand
 *
 * @author Balika
 */
class HubBidCommand extends Command {

    protected static $defaultName = "hub:update-bid-slots";
    /*
     * @var \App\Services\PersistenceService;
     */
    protected $persistenceService;

    public function __construct(PersistenceService $persistenceService) {
        $this->persistenceService = $persistenceService;
        parent::__construct();
    }

    protected function configure() {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln([
            'Bid Slot Command Initiated',
            '============',
            '',
        ]);
        $output->writeln(['Loading Bid Slots', '==========================================']);
        $bidSlots = $this->persistenceService->getRepository(EntityConfig::HUB_BID)->findAll();
        foreach ($bidSlots as $key => $slot) {
            $output->writeln($key . '--------------------------------' . $slot->getName());
            if ($slot->getIsOpen()) {
                $output->writeln($slot->getName() . ' is open');
            }
            $today = new DateTime();          
            if($slot->getEndingAt() < $today && $slot->getIsOpen()){
                $slot->setIsOpen(FALSE);
                $output->writeln($slot . ' is being closed');
                $this->persistenceService->persist($slot);                
            }
            $output->writeln('++++++++++++++++++++++++++++++++++++++++++');
        }
        $this->persistenceService->flush();
    }
}
