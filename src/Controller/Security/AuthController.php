<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 2:57 AM
 */

namespace App\Controller\Security;

use App\Entity\PasswordUpdate;
use App\Form\UpdatePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
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