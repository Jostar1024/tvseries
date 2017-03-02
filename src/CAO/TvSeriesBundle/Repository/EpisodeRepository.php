<?php
//namespace CAO\TvSeriesBundle\Repository;
//
//use Doctrine\ORM\EntityRepository;
//use Doctrine\ORM\Tools\Pagination\Paginator;
///**
// * Created by PhpStorm.
// * User: caoych
// * Date: 2017/3/2
// * Time: 17:48
// */
//class EpisodeRepository extends EntityRepository
//{
//    /**
//     * @param int $currentPage
//     * @return \Doctrine\ORM\Tools\Pagination\Paginator
//     */
//    public function getAllEpisodes($currentPage = 1)
//    {
//        $query = $this->createQueryBuilder('p')
//            ->orderBy('p.name', 'DESC')
//            ->getQuery();
//
//        $paginator = $this->paginate($query, $currentPage);
//
//        return $paginator;
//    }
//
//    /**
//     * @param $dql
//     * @param int $page
//     * @param int $limit
//     * @return Paginator
//     */
//    public function paginate($dql, $page=1, $limit=5)
//    {
//        $paginator = new Paginator($dql);
//
//        $paginator->getQuery()
//            ->setFirstResult($limit * ($page - 1))
//            ->setMaxResults($limit);
//
//        return $paginator;
//    }
//}