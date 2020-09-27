<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 5:14 PM
 */

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingCreateType;
use App\Manager\BookingManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookingController
 * @package App\Controller
 *
 * @Route("/book", name="book_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class BookingController extends AbstractController
{
    protected $bookingManager;

    public function __construct(
        BookingManager $bookingManager
    )
    {
        $this->bookingManager = $bookingManager;
    }

    /**
     * @Route("/{slug}/create", name="create")
     *
     * @IsGranted("ROLE_USER")
     * @param Ad $ad
     * @param Request $request
     *
     * @return Response
     */
    public function createBooking(Ad $ad, Request $request)
    {
        $booking = $this->bookingManager->createBooking();
        $form = $this->createForm(BookingCreateType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setBooker($this->getUser())
                ->setAd($ad)
            ;
            $this->bookingManager->save($booking);

            return $this->redirectToRoute('book_show', [
                'id' => $booking->getId(),
                'withAlert' => true
            ]);
        }

        return $this->render('booking/create.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/show", name="show")
     *
     * @param Booking $booking
     *
     * @return Response
     */
    public function showBooking(Booking $booking)
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}