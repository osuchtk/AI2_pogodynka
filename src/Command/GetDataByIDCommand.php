<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\LocalisationRepository;
use App\Repository\MeasuresRepository;
use App\Service\WeatherUtil;


#[AsCommand(
    name: 'getDataByID',
    description: 'Command using service and getWeatherForLocation method'
)]
class GetDataByIDCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('ID', InputArgument::REQUIRED, 'Localisation ID');
    }

    private WeatherUtil $weatherUtil;
    private LocalisationRepository $localisationRepository;
    public function __construct(WeatherUtil $weatherUtil, LocalisationRepository $localisationRepository)
    {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;   
        $this->localisationRepository = $localisationRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $localisationID = $input->getArgument('ID');

        $localisation = $this->localisationRepository->findOneBy([
            "id" => $localisationID,
        ]);

        $measures = $this->weatherUtil->getWeatherLocation($localisation);

        foreach($measures as $measure){
            $output->writeln(strval($measure));
        }
        
        return Command::SUCCESS;
    }
}
