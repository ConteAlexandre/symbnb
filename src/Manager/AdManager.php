<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/26/20
 * Time: 6:33 PM
 */

namespace App\Manager;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AdManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdManager
{
    protected $em;
    protected $adRepository;
    protected $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        AdRepository $adRepository,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->adRepository = $adRepository;
        $this->logger = $logger;
    }

    /**
     * @return Ad[]
     */
    public function getAll()
    {
        $ad = $this->adRepository->findAll();
        return $ad;
    }

    /**
     * @param string $slug
     * @return Ad
     */
    public function getBySlug(string $slug)
    {
       $ad = $this->adRepository->findOneBySlug($slug);
       return $ad;
    }

    /**
     * @return Ad
     */
    public function createAnnouncement()
    {
        $ad = new Ad();
        return $ad;
    }

    /**
     * @param Ad $ad
     * @param bool $andFlush
     */
    public function save(Ad $ad, $andFlush = true)
    {
        $this->em->persist($ad);
        if ($andFlush){
            $this->em->flush();
        }
    }

    /**
     * @param $slug
     * @param bool $andFlush
     */
    public function deleteAnnouncement($slug, $andFlush = true)
    {
        $ad = $this->adRepository->findOneBySlug($slug);
        $this->em->remove($ad);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}