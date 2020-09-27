<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 2:57 AM
 */

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthController
 * @package App\Controller\Security
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'hasError' => $error != null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @return void
     */
    public function logout()
    {

    }
}