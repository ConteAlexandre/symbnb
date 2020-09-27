<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 5:13 PM
 */

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'startDate',
                DateType::class,
                $this->getConfiguration('Date Arrived', 'Start Date travel', [
                    "widget" => "single_text"
                ])
            )
            ->add(
                'endDate',
                DateType::class,
                $this->getConfiguration('Date Leave', 'End Date travel',  [
                    "widget" => "single_text"
                ])
            )
            ->add(
                'comment',
                TextareaType::class,
                $this->getConfiguration(false, 'Write a comment if necessary')
            )
        ;
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