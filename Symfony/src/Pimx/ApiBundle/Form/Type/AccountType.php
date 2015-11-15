<?php

namespace Pimx\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('code', 'text')
                ->add('description', 'text', array('required'=>true))
                /*->add('type', 'entity', array(
                    'class' => 'PimxModelBundle:AccountType',
                    'property' => 'description',
					'required' => false
                ))
                ->add('group', 'entity', array(
                    'class' => 'PimxModelBundle:AccountGroup',
                    'property' => 'description',
					'required' => false
                ))*/
                //->add('currency', 'entity', array(
                //    'class' => 'PimxModelBundle:Currency',
                //    'property' => 'name',
                //))
                ->add('sign', 'integer')
                //->add('notes', 'textarea', array('required' => false))
			;
    }

    public function getName() {
        return 'account';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pimx\ModelBundle\Entity\Account',
			'csrf_protection' => false
        ));
    }

}