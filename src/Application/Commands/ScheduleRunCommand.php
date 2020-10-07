<?php

namespace App\Application\Commands;

use App\Application\SocketOperations\SocketOperationFactory;
use App\Domain\EventService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScheduleRunCommand extends Command
{
    protected $eventService;
    protected $socketOperationFactory;

    public function __construct(EventService $eventService, SocketOperationFactory $socketOperationFactory)
    {
        $this->eventService = $eventService;
        $this->socketOperationFactory = $socketOperationFactory;
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('schedule:run');
        $this->setDescription('Run the scheduled events');
    }

    protected function getOperation($operationName, $socket)
    {
        return $this->socketOperationFactory->createSocketOperation($operationName, $socket);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $events = $this->eventService->findDue();

        if ($events)
        {
            $output->writeln("Running events");

            foreach ($events as $event)
            {
                $operation = $this->getOperation($event->getOperationName(), $event->getSocket());
                $operation->run();
            }

        }

        return 0;
    }
}
