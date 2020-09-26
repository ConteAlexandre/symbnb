<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/26/20
 * Time: 10:39 PM
 */

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdCreateType
 * @package App\Form
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('introduction')
            ->add('content')
            ->add('rooms')
            ->add('price')
            ->add('coverImage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Ad::class
            ]);
    }
}