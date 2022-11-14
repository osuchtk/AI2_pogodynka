<?php

namespace App\Service;

use App\Repository\LocalisationRepository;
use App\Repository\MeasuresRepository;
use App\Entity\Localisation;

class WeatherUtil
{
    private MeasuresRepository $measuresRepository;
    private LocalisationRepository $localisationRepository;
    public function __construct(MeasuresRepository $measuresRepository, LocalisationRepository $localisationRepository)
    {
        $this->measuresRepository = $measuresRepository;
        $this->localisationRepository = $localisationRepository;
    }

    public function getWeatherForCountryAndCity($countryCode, $city): array
    {
        $localisation = $this->localisationRepository->findOneBy([
            "City" => $city,
            "CountryCode" => $countryCode,
        ]);
		$measures = $this->getWeatherLocation($localisation);
        
        return $measures;
    }

    public function getWeatherLocation(Localisation $localisation)
	{
		$measures = $this->measuresRepository->findByLocation($localisation);
        
        return $measures;
	}
}