<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

class VilleCommand extends Command
{
    protected static $defaultName = 'app:ville';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    private $kernel;

    public function __construct(
        string $name = null,
        EntityManagerInterface $em, KernelInterface $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        //$arg1 = $input->getArgument('arg1');

        $csv = '/var/lib/mysql-files/ville.csv';
        if(file_exists($csv)){
            $this->loadFileInDB($csv,$io);
            $io->success('Fichier OK');
        }else{
            $io->success('File not found');
        }
    }

    public function loadFileInDB($file, $io)
    {
        $debutExec = new \DateTime('now');
        $io->success($debutExec->format('i:h:s'));
//        $this->viderTable();
        $connection = $this->em->getConnection();
        //  $file = 'C:/wamp/www/bba-fec/web/upload/test__.txt';
        $sql = "LOAD DATA INFILE '$file' INTO TABLE ville CHARACTER SET UTF8
                FIELDS TERMINATED BY ';' 
                LINES TERMINATED BY '\\n'
                IGNORE 1 LINES
                (@eu_circo,@code_region,@nom_region,@chef_lieu_region,@numero_departement,@nom_departement,@prefecture,
                @numero_circonscription,@nom_commune,@codes_postaux,@code_insee,@latitude,@longitude,@eloignement)
                SET eu_circo = @eu_circo,
                    code_region=@code_region, 
                    nom_region=@nom_region,
                    chef_lieu_region=@chef_lieu_region, 
                    numero_departement=@numero_departement,
                    nom_departement=@nom_departement,
                    prefecture=@prefecture,
                    numero_circonscription=@numero_circonscription,
                    nom_commune=@nom_commune,
                    codes_postaux=@codes_postaux,
                    code_insee=@code_insee,
                    latitude=if(@latitude='' || @latitude='-', 0, REPLACE(@latitude, ',', '.')),
                    longitude=if(@longitude=''|| @longitude='-', 0, REPLACE(@longitude, ',', '.')),
                    eloignement=if(@eloignement=''|| @eloignement='-', 0, REPLACE(@eloignement, ',', '.'))
                ";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $debutExec = new \DateTime('now');
        $io->success( $debutExec->format('i:h:s'));
    }

    public function viderTable()
    {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("TRUNCATE TABLE ville");
        $resultat = $statement->execute();
    }
}
