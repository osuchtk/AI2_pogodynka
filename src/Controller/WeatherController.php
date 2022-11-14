<?php // src/Controller/WeatherController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Localisation;
use App\Entity\Measures;
use App\Repository\LocalisationRepository;
use App\Repository\MeasuresRepository;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    public function cityAction($countryCode, $city, WeatherUtil $weatherutil): Response
    {
        //$localisation = $localisationRepository->find($localisationId);
		//$measures = $measuresRepository->findByLocation($localisation, $localisationRepository);
		$measures = $weatherutil->getWeatherForCountryAndCity($countryCode, $city);

        
        return $this->render('weather/index.html.twig', [
            //'localisation' => $localisation,
            //'country' => $countryCode,
			'measures' => $measures,
        ]);
    }
}
