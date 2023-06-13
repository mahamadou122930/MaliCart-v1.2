<?php

namespace App\Command;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemoveExpiredCartsCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    protected static $defaultName = 'app:remove-expired-carts';

    /**
     * RemoveExpiredCartsCommand constructor.
     */

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Remove carts that have been inactive dor defined period')
            ->addArgument(
                'days', 
                InputArgument::OPTIONAL, 
                'The Number of day a cart can remain inactive',
                2
                )
            
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $days = $input->getArgument('days');

        if ($days <= 0) {
            $io->error('The number of days should be greater than 0.');

            return Command::FAILURE;
        }

        // Subtracts the number of days from the current date.
        $limitDate = new \DateTime("- $days days");
        $expiredCartsCount = 0;

        while ($carts = $this->orderRepository->findCartNotModifiedSince($limitDate)) {
            foreach ($carts as $cart) {
                // Item will be deleted on cascade
                $this->entityManager->remove($cart);
            }
            $this->entityManager->flush(); // Executes all deletions
            $this->entityManager->clear(); // Detaches all object from Doctrine

            $expiredCartsCount += count($carts);
        }

        if ($expiredCartsCount) {
            $io->success("$expiredCartsCount cart(s) have been deleted.");
        } else {
            $io->info('No expired carts.');
        }

        return Command::SUCCESS;
    }
}
