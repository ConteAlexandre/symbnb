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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
    /**
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Title', 'Title of announcement'))
            ->add('slug', TextType::class, $this->getConfiguration('Slug', 'Web Address (auto)'))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Url of the image', 'Give the address for the beautiful image'))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', 'Write description for this announcement'))
            ->add('content', TextareaType::class, $this->getConfiguration('Content', 'Write the all description'))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Number Rooms', 'Enter the number rooms for the announcement'))
            ->add('price', MoneyType::class, $this->getConfiguration('Price for one night', 'Write the price'))
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