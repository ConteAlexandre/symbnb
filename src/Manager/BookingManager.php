<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 5:19 PM
 */

namespace App\Manager;

use App\Entity\Booking;
use App\Repository\AdRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\User;

/**
 * Class BookingManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class BookingManager
{
    protected $em;
    protected $bookingRepository;
    protected $adRepository;
    protected $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        BookingRepository $bookingRepository,
        AdRepository $adRepository,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->bookingRepository = $bookingRepository;
        $this->adRepository = $adRepository;
        $this->logger = $logger;
    }

    public function createBooking()
    {
        $booking = new Booking();
        return $booking;
    }

    public function save(Booking $booking, $andFlush = true)
    {
        $this->em->persist($booking);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}