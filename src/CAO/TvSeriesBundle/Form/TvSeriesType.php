<?php
/**
 * Created by PhpStorm.
 * User: caoych
 * Date: 2017/2/26
 * Time: 12:22
 */

namespace CAO\TvSeriesBundle\Form;


use CAO\TvSeriesBundle\Entity\TvSeries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TvSeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('author', TextType::class)
            ->add('releaseAt', DateType::class)
            ->add('description', TextType::class)
            ->add('image', FileType::class, array(
                'label' => 'Image (optional)'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TvSeries::class,
        ));
    }
}