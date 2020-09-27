<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 5:13 PM
 */

namespace App\Form;

use App\Entity\Booking;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookingCreateType
 * @package App\Form
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class BookingCreateType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $dateTimeTransformer)
    {
        $this->transformer = $dateTimeTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'startDate',
                TextType::class,
                $this->getConfiguration('Date Arrived', 'Start Date travel')
            )
            ->add(
                'endDate',
                TextType::class,
                $this->getConfiguration('Date Leave', 'End Date travel')
            )
            ->add(
                'comment',
                TextareaType::class,
                $this->getConfiguration(false, 'Write a comment if necessary', [
                    'required' => false
                ])
            )
        ;

        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Booking::class,
            ]);
    }
}