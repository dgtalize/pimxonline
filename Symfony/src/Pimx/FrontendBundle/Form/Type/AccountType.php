<?php

namespace Pimx\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('code', 'text')
                ->add('description', 'text')
                ->add('type', 'entity', array(
                    'class' => 'PimxModelBundle:AccountType',
                    'property' => 'description',
                ))
                ->add('group', 'entity', array(
                    'class' => 'PimxModelBundle:AccountGroup',
                    'property' => 'description',
                ))
                ->add('sign', 'integer')
                ->add('notes', 'textarea');
    }

    public function getName() {
        return 'account';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pimx\ModelBundle\Entity\Account',
        ));
    }

}