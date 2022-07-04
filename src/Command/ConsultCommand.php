<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use App\Repository\SaveHashRepository;
use App\Entity\SaveHash;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\SaveController;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:consult')]
class ConsultCommand extends Command
{
    private $entityManager;

    public function __construct(SaveHashRepository $entityManager,SaveController $savecontroller)
    {
        $this->entityManager= $entityManager;
        $this->SaveController=$savecontroller;
        // you *must* call the parent constructor
        ini_set('memory_limit', '-1');
        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:consult')
    
            // the short description shown while running "php bin/console list"
            ->setDescription('Consult table hash.')
    
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to Consult hash...")
            ->addArgument('parametro', InputArgument::REQUIRED, 'parametro.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $param = $input->getArgument('parametro');
        if($param!=null){
            $query = $this->entityManager->createQueryBuilder('h')
            ->where('h.tentativas <'.$param)
            ->orderBy('h.tentativas', 'ASC')->getQuery();
            $resul= $query->getResult()->paginate();
        }else{
            $query = $this->entityManager->createQueryBuilder('h')
            ->orderBy('h.hash', 'ASC')->getQuery();
            $resul= $query->getResult();
        }

         foreach($resul as $values){
             $output->writeln('data: ' . date_format($values->getBatch(),"Y/m/d H:i:s") 
                            .' ID: ' .$values->getId()
                            .' Entrada: ' .$values->getEntrada()
                            .' key: ' .$values->getChave()
                            .' Hash: ' .$values->getHash()
                            .' Tentativas: ' .$values->getTentativas()
                         );
         }
         
        return Command::SUCCESS;
    }
}