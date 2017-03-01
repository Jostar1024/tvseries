<?php
/**
 * Created by PhpStorm.
 * User: caoych
 * Date: 2017/2/28
 * Time: 14:09
 */

namespace CAO\TvSeriesBundle\Form;

use CAO\TvSeriesBundle\Entity\Episode;
use CAO\TvSeriesBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserEpisodeType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('current', IntegerType::class)
            ->add('watechedAt', DateType::class)
            ->add('episode', EntityType::class, array(
                'class' => Episode::class,
                'choice_label' => 'id'
            ))
            ->add('user', EntityType::class, array(
                'class' => User::class,
                'choice_label' => 'id'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CAO\TvSeriesBundle\Entity\UserEpisode'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cao_tvseriesbundle_userepisode';
    }

}