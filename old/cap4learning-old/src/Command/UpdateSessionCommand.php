<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Manager\TrainingManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSessionCommand extends Command
{
    private $trainingManager;
    protected static $defaultName = 'app:session:update';

    public function __construct(TrainingManager $trainingManager) {
        $this->trainingManager = $trainingManager;

        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $trainings = $this->trainingManager->findAll();
        foreach ($trainings as $training) {
            $session = $training->getNextSession();
            if ($session) {
                $training->setNextDate($session->getStartDate());
            } else {
                $training->setNextDate(null);
            }
            $this->trainingManager->save($training);
        }
        return 0;
    }
}