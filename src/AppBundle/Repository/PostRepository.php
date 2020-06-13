<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    //add f 2 parameters
    public function getArticles($nbPerPage, $page)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();

        // the first article - offset
        $query->setFirstResult(($page-1) * $nbPerPage)
        // the max display articles
        ->setMaxResults($nbPerPage);
        //return la query sql dans Paginator
        return new Paginator($query);
    }

    public function getMaxPublishedArticleCount(){
        $articleCount = $this->createQueryBuilder('a')
            // Filter by some parameter if you want
            // ->where('a.published = 1')
            ->select('count(a.id)')
            ->where('a.published = 1')
            ->getQuery()
            ->getSingleScalarResult();

        return $articleCount;
    }
}
