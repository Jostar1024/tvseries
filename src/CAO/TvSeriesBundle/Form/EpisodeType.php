<?php

namespace CAO\TvSeriesBundle\Form;

use CAO\TvSeriesBundle\Entity\TvSeries;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('episodeNumber')
            ->add('datePublished', DateType::class)
            ->add('description')
            ->add('image', FileType::class, array(
                'label' => 'Image (optional)',
                'required' => false
            ))
            ->add('tvSeries', EntityType::class, array(
                'class' => TvSeries::class,
                'choice_label' => 'name'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CAO\TvSeriesBundle\Entity\Episode'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cao_tvseriesbundle_episode';
    }


}
