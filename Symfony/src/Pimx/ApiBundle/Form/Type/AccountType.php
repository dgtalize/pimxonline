<?php

namespace Pimx\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;

class AccountType extends AbstractType {

	private $container;

	public function __construct($container) {
		$this->container = $container;
	}

    public function buildForm(FormBuilderInterface $builder, array $options) {
		$accountTypeTransformer = new EntityToIdObjectTransformer(
				$this->container->get('doctrine')->getManager(), 
				"PimxModelBundle:AccountType");
		
        $builder->add('code', 'text')
                ->add('description', 'text', array('required'=>true))
                /*->add('type', 'entity', array(
                    'class' => 'PimxModelBundle:AccountType',
                    'property' => 'description',
					'required' => false
                ))*/
				->add($builder->create('type', 'text')->addModelTransformer($accountTypeTransformer))
                /*->add('group', 'entity', array(
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