<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/26/20
 * Time: 6:22 PM
 */

namespace App\Controller;

use App\Form\AdCreateType;
use App\Manager\AdManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdController
 * @package App\Controller
 *
 * @Route("/ad", name="ad_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdController extends AbstractController
{
    /**
     * @var AdManager $adManager
     */
    protected $adManager;

    public function __construct(AdManager $adManager)
    {
        $this->adManager = $adManager;
    }

    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @return Response
     */
    public function listAnnouncements()
    {
        $ads = $this->adManager->getAll();

        return $this->render(
            'Ad/list.html.twig', [
                'ads' => $ads,
            ]
        );
    }

    /**
     * @Route("/show/{slug}", name="show", methods={"GET"})
     *
     * @param string $slug
     *
     * @return Response
     */
    public function showAnnouncement(string $slug)
    {
        $ad = $this->adManager->getBySlug($slug);

        return $this->render(
            'Ad/show.html.twig',
            [
                'ad' => $ad,
            ]
        );
    }

    /**
     * @Route("/create", name="create")
     *
     * @return Response
     */
    public function createAnnouncement()
    {
        $ad = $this->adManager->createAnnouncement();
        $form = $this->createForm(AdCreateType::class, $ad);

        return $this->render(
            'Ad/create.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }
}