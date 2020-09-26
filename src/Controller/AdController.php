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
     */
    public function listAnnouncements(AdManager $adManager)
    {
        $ads = $adManager->getAll();

        return $this->render(
            'Ad/list_ad.html.twig', [
                'ads' => $ads
            ]
        );
    }
}