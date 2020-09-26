<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/26/20
 * Time: 6:22 PM
 */

namespace App\Controller;

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
     * @Route("/list", name="list", methods={"GET"})
     *
     * @param AdManager $adManager
     *
     * @return Response
     */
    public function listAnnouncements(AdManager $adManager)
    {
        $ads = $adManager->getAll();

        return $this->render(
            'Ad/list.html.twig', [
                'ads' => $ads
            ]
        );
    }

    /**
     * @Route("/show/{slug}", name="show", methods={"GET"})
     *
     * @param string $slug
     * @param AdManager $adManager
     *
     * @return Response
     */
    public function showAnnouncement(string $slug, AdManager $adManager)
    {
        $ad = $adManager->getBySlug($slug);

        return $this->render(
            'Ad/show.html.twig',
            [
                'ad' => $ad
            ]
        );
    }
}