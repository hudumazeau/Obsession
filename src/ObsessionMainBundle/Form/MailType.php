<?php

namespace ObsessionMainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail','email',array('label'=>'Email du destinataire'))
            ->add('objet','text',array('label'=>'Objet'))
            ->add('pj','file',array('label'=>'&nbsp;','required'=>false,'attr'=>array('style'=>'visibility:hidden')))
            ->add('message','textarea',array('label'=>'Message','attr'=>array('rows'=>'6')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObsessionMainBundle\Entity\Mail'
        ));
    }
}
