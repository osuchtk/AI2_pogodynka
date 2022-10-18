<?php

namespace App\Repository;

use App\Entity\Measures;
use App\Entity\Localisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LocalisationRepository;


class MeasuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measures::class);
    }

    public function findByLocation(Localisation $localisationId, LocalisationRepository $localisationRepository)
	{
		$localisation = $localisationRepository->find($localisationId);
		
		$qb = $this->createQueryBuilder('m');
		$qb->where('m.localisation = :localisation')
			->setParameter('localisation', $localisation);
		
		//$qb = $this->createQueryBuilder('m');
		//$qb->join('m.localisation', 'l', 'WITH', 'l.id = m.localisation')
		//->andWhere('l.city = :city')
		//->setParameter('city', $city)
		//->andWhere('l.country = :countryCode')
		//->setParameter('countryCode', $countryCode);

		$query = $qb->getQuery();
		$result = $query->getResult();
		
		return $result;
	}
}