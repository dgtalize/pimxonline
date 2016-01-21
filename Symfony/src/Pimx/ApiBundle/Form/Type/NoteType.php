<?php

namespace Pimx\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text')
                ->add('isEncrypted', 'checkbox', array('required' => false))
                ->add('cryptPassword', 'password', array('required' => false))
                ->add('content', 'textarea', array(
                    'required' => true,
                    'attr' => array('class' => 'wysiwyg')
                    ));
    }

    public function getName() {
        return 'note';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pimx\ModelBundle\Entity\Note',
        ));
    }

}