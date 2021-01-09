<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 3:37 AM
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;

/**
 * Class ApplicationType
 * @package App\Form
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class ApplicationType extends AbstractType
{
    /**
     * @param $label
     * @param $placeholder
     * @param array $options
     *
     * @return array
     */
    protected function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
}