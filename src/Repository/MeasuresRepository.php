<?php

namespace App\Repository;

use App\Entity\Measures;
use App\Entity\Localisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LocalisationRepository;


class MeasuresRepository extends ServiceEntityRepository
{
	private LocalisationRepository $localisationRepository;
    public function __construct(ManagerRegistry $registry, LocalisationRepository $localisationRepository)
    {
        parent::__construct($registry, Measures::class);
		$this->localisationRepository = $localisationRepository;
    }

    public function findByLocation(Localisation $localisation)
	{
		$localisationFound = $this->localisationRepository->find($localisation);
		
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.localisation = :localisation')
			->setParameter('localisation', $localisationFound);

		$query = $qb->getQuery();
		$result = $query->getResult();
		
		return $result;
	}
}