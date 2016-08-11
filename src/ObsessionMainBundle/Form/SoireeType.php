<?php

namespace ObsessionMainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoireeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date','date',array('label'=>'Date de la soirée'))
            ->add('lieu',EntityType::class,array(
                'label'=>'Lieu',
                'class'=>'ObsessionMainBundle\Entity\Lieu',
                'required'=>true
            ))
            ->add('theme','text',array('label'=>'Theme','required'=>false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObsessionMainBundle\Entity\Soiree'
        ));
    }
}
