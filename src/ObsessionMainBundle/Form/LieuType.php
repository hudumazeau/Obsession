<?php

namespace ObsessionMainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text',array('label'=>'Nom de la salle'))
            ->add('adresse','text',array('label'=>'Adresse'))
            ->add('code','integer',array('label'=>'Code postale'))
            ->add('ville','text',array('label'=>'Ville'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObsessionMainBundle\Entity\Lieu'
        ));
    }
}
