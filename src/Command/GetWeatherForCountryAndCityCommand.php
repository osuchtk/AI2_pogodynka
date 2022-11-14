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
use App\Entity\Localisation;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'getWeatherForCountryAndCity',
    description: 'Get weather by giving country code and city name.',
)]
class GetWeatherForCountryAndCityCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Country Code, for example "pl"')
            ->addArgument('city', InputArgument::REQUIRED, 'City name, for example "szczecin"');
    }

    private WeatherUtil $weatherUtil;
    public function __construct(WeatherUtil $weatherUtil)
    {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $countryCode = $input->getArgument('countryCode');
        $city = $input->getArgument('city');

        $measures = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $city);

        foreach($measures as $measure){
            $output->writeln(strval($measure));
        }

        return Command::SUCCESS;
    }
}
