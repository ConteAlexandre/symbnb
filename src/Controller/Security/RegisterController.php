<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 3:23 AM
 */

namespace App\Controller\Security;

use App\Form\RegisterType;
use App\Manager\UsersManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController
 * @package App\Controller\Security
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class RegisterController  extends AbstractController
{
    protected $userManager;

    public function __construct(UsersManager $usersManager)
    {
        $this->userManager = $usersManager;
    }

    /**
     * @Route("/register", name="register")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $user = $this->userManager->createUser();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->save($user);

            $this->addFlash(
                'success',
                "Your account is been to created"
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}