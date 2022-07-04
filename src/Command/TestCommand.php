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
#[AsCommand(name: 'app:test')]
class TestCommand extends Command
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
            ->setName('app:test')
    
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates new hash.')
    
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to create hash...")
            ->addArgument('hash', InputArgument::REQUIRED, 'hash.')
            ->addOption(
                'requests',
                null,
                InputOption::VALUE_REQUIRED,
                'How many times should the execute?',
                1
            );
    }

    function getRandom($length){
       
        $str = 'abcdefghijklmnopqrstuvwzyz';
        $str1= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str2= '0123456789';
        $shuffled = str_shuffle($str);
        $shuffled1 = str_shuffle($str1);
        $shuffled2 = str_shuffle($str2);
        $total = $shuffled.$shuffled1.$shuffled2;
        $shuffled3 = str_shuffle($total);
        $result= substr($shuffled3, 0, $length);

        return $result;
    }


    public function consulta($filtro){
        $filtro;

        $query = $this->entityManager->createQueryBuilder('h')->orderBy('h.hash', 'ASC')->getQuery();
        $resul= $query->getResult();

         foreach($resul as $values){
             $output->writeln('data: ' . date_format($values->getBatch(),"Y/m/d H:i:s") 
                             .'Entrda: ' .$values->getEntrada()
                             .'Hash: ' .$values->getHash()
                             .'key: ' .$values->getChave()
                             .'Tentativas: ' .$valuesgetTentativas()
                         );
         }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
            $hashguard = new SaveHash;
            $repeat = $input->getOption('requests');
            $hash_name= $input->getArgument('hash');
            $key = $this->getRandom(8);
    
            for($i=0;$i<$repeat;$i++){
                $tentativas=0;
                $Hash ='';
    
                while(substr($Hash, 0, 4)!=="0000"){
                    $Hash = md5($hash_name . $key);
                    $key = $this->getRandom(8);
                    $tentativas++;
                    $output->writeln(' hash '.$Hash);
                }
    
                $hashguard->setBatch(new \DateTime());
                $hashguard->setEntrada($hash_name);
                $hashguard->setChave($key);
                $hashguard->setHash($Hash);
                $hashguard->setTentativas($tentativas);
                $this->SaveController->index($hashguard);
    
                $hash_name= $hash_name;
                $salvos[]=$hashguard;
            }
    
            foreach($salvos as $values){
                $output->writeln('data: ' . date_format($values->getBatch(),"Y/m/d H:i:s") 
                                .'Entrda: ' .$values->getEntrada()
                                .'Hash: ' .$values->getHash()
                                .'key: ' .$values->getChave()
                                .'Tentativas: ' .$valuesgetTentativas()
                            );
            }

        return Command::SUCCESS;
    }
}