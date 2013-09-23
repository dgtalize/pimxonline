<?php

namespace Pimx\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovementType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text')
                ->add('date', 'datetime', array('date_widget' => 'single_text', 'time_widget' => 'single_text'))
                ->add('type', 'entity', array(
                    'class' => 'PimxModelBundle:MovementType',
                    'property' => 'description',
                ))
                ->add('group', 'entity', array(
                    'class' => 'PimxModelBundle:MovementGroup',
                    'property' => 'description',
                ))
                ->add('notes', 'textarea')
                ->add('appliedAccounts', 'collection', array(
                    'type' => new MovementAccountType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                    ))
                ->add('labels', 'collection', array(
                    'type' => new LabelType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                    ));
    }

    public function getName() {
        return 'movement';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pimx\ModelBundle\Entity\Movement',
        ));
    }

}