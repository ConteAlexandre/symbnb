<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 4:11 AM
 */

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Form\ProfileType;
use App\Form\UpdatePasswordType;
use App\Manager\UsersManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * @var UserPasswordEncoderInterface $encoderPassword
     */
    protected $encoderPassword;

    public function __construct(UsersManager $usersManager, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userManager = $usersManager;
        $this->em = $entityManager;
        $this->encoderPassword = $passwordEncoder;
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
     * @Route("/update-password", name="update_password")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class, $passwordUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Verification the oldPassword between the new password
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("The old password is not equal"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $password = $this->encoderPassword->encodePassword($user, $newPassword);
                $user->setPassword($password);
                $this->em->persist($user);
                $this->em->flush();

                $this->addFlash(
                    'success',
                    'Update password it\'s ok '
                );
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('users/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}