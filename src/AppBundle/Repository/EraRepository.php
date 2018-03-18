<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EraRepository extends EntityRepository
{
    public function getAllEraByLocale($locale)
    {
        $result = $this->createQueryBuilder('era')
            ->select('translations.name, translations.slug')
            ->join('era.translations', 'translations')
            ->where('translations.locale = :locale')
            ->setParameters([
                'locale' => $locale
            ])
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

    public function getAllGmByEraByLocale($slugEra, $locale)
    {
        $result = $this->createQueryBuilder('era')
            ->select('gmsTranslations.name, gmsTranslations.description, gms.id, gms.image, gmsTranslations.slug')
            ->join('era.gms', 'gms')
            ->join('era.translations', 'eraTranslations')
            ->join('gms.translations', 'gmsTranslations')
            ->where('gmsTranslations.locale = :locale')
            ->andWhere('eraTranslations.slug = :slugCategory')
            ->setParameters([
                'locale' => $locale,
                'slugCategory' => $slugEra
            ])
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

    public function getEraBySlugByLocale($slugEra, $locale)
    {
        $result = $this->createQueryBuilder('era')
            ->select('translations.name, translations.slug')
            ->join('era.translations', 'translations')
            ->where('translations.locale = :locale')
            ->andWhere('translations.slug = :slugEra')
            ->setParameters([
                'locale' => $locale,
                'slugEra' => $slugEra
            ])
            ->getQuery()
            ->getSingleResult()
        ;
        return $result;
    }

//    public function getGmByLocale($slugEra, $slugGm, $locale)
//    {
//        $result = $this->createQueryBuilder('era')
//            ->select('gmsTranslations.name, gmsTranslations.description, gms.id, gmsTranslations.slug')
//            ->join('era.gms', 'gms')
//            ->join('era.translations', 'eraTranslations')
//            ->join('gms.translations', 'gmsTranslations')
//            ->where('gmsTranslations.locale = :locale')
//            ->andWhere('eraTranslations.slug = :slugEra')
//            ->andWhere('gmsTranslations.slug = :slugGm')
//            ->setParameters([
//                'locale' => $locale,
//                'slugEra' => $slugEra,
//                'slugGm' => $slugGm
//            ])
//            ->getQuery()
//            ->getSingleResult()
//        ;
//        return $result;
//    }
}
