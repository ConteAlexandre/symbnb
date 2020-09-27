<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 3:23 AM
 */

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegisterType
 * @package App\Form
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class RegisterType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
            $this->getConfiguration("firstName", "Your FirstName")
            )
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration('lastName', "Your LastName")
            )
            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration('Mail', "Your Email")
            )
            ->add(
                'picture',
                UrlType::class,
                $this->getConfiguration("Avatar", "Your Avatar")
            )
            ->add(
                'password',
                PasswordType::class,
                $this->getConfiguration("Password", "Enter a password")
            )
            ->add(
                'passwordConfirm',
                PasswordType::class,
                $this->getConfiguration('Password Confirmation', 'Confirm your password')
            )
            ->add(
                'introduction',
                TextType::class,
                $this->getConfiguration("Introduction", "Write introduction on you")
            )
            ->add(
                'description',
                TextType::class,
                $this->getConfiguration("Description", "Write description on you")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Users::class
            ]);
    }
}