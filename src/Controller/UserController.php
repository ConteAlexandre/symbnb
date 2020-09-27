<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 4:11 AM
 */

namespace App\Controller;

use App\Form\ProfileType;
use App\Manager\UsersManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/user", name="user_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserController extends AbstractController
{
    /**
     * @var UsersManager$userManager
     */
    protected $userManager;

    /**
     * @var EntityManagerInterface $em
     */
    protected $em;

    public function __construct(UsersManager $usersManager, EntityManagerInterface $entityManager)
    {
        $this->userManager = $usersManager;
        $this->em = $entityManager;
    }

    /**
     * @Route("/edit", name="edit")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editUser(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Profile is update with success'
            );
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{slug}/profile", name="profile")
     *
     * @return Response
     */
    public function profileUser($slug)
    {
        $user = $this->userManager->getUserBySlug($slug);

        return $this->render('users/profile.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/myprofile", name="myPofile")
     *
     * @return Response
     */
    public function myProfile()
    {
        return $this->render('users/profile.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}