<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GmRepository extends EntityRepository
{
    public function getAllGmByLocale($locale)
    {
        $result = $this->createQueryBuilder('gm')
            ->select('gmTranslations.name, gmTranslations.description, gm.id, gmTranslations.slug')
            ->join('gm.translations', 'gmTranslations')
            ->where('gmTranslations.locale = :locale')
            ->setParameters([
                'locale' => $locale
            ])
            ->getQuery()
            ->getArrayResult()
        ;
        return $result;
    }

    public function getGmIdBySlugByLocale($slugGm, $locale)
    {
        $result = $this->createQueryBuilder('gm')
            ->select('gm.id')
            ->join('gm.translations', 'gmTranslations')
            ->where('gmTranslations.locale = :locale')
            ->andWhere('gmTranslations.slug = :slugGm')
            ->setParameters([
                'locale' => $locale,
                'slugGm' => $slugGm
            ])
            ->getQuery()
            ->getSingleResult()
        ;
        return $result;
    }
//
//    public function getGmBySlugByLocale($slugGm, $locale)
//    {
//        $result = $this->createQueryBuilder('gm')
//            ->select('gmTranslations.name, gmTranslations.description, gm.id, gmTranslations.slug')
//            ->join('gm.translations', 'gmTranslations')
//            ->where('gmTranslations.locale = :locale')
//            ->andWhere('gmTranslations.slug = :slugGm')
//            ->setParameters([
//                'locale' => $locale,
//                'slugGm' => $slugGm
//            ])
//            ->getQuery()
//            ->getSingleResult()
//        ;
//        return $result;
//    }
}
