<?php

namespace Pimx\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovementFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('date_start', 'date', array('widget' => 'single_text', 'required' => false))
                ->add('date_end', 'date', array('widget' => 'single_text', 'required' => false))
                ->add('Filter', 'submit')
                ->setMethod('GET')
            ;
    }

    public function getName() {
        return 'movement_filter';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        
    }

}