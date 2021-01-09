<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 12:46 AM
 */

namespace App\Manager;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ImageManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class ImageManager
{
    protected $em;
    protected $imageRepository;
    protected $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->imageRepository = $imageRepository;
        $this->logger = $logger;
    }

    /**
     * @param Image $image
     * @param bool $andFlush
     */
    public function save(Image $image, $andFlush = true)
    {
        $this->em->persist($image);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}