<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/26/20
 * Time: 12:51 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function home()
    {
        $prenoms = ["Lior" => 31, "Joseph" => 12, "Anne" => 55];

        return $this->render(
            'home.html.twig',
            [
                'title' => "Bonjour à tous !",
                'age' => 15,
                'tableau' => $prenoms
            ]
        );
    }
}