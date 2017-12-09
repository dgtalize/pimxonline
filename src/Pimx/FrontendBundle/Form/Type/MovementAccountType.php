<?php

namespace Pimx\FrontendBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Pimx\ModelBundle\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovementAccountType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('account', EntityType::class, array(
            'class' => Account::class,
            'property' => 'description',
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('a')->orderBy('a.description', 'ASC');
            }
        ))
//                ->add('sign', 'choice', array(
//                    'choices' => array('1' => 'In', '-1' => 'Out'),
//                    'required' => true
//                ))
            ->add('sign', HiddenType::class, array(
                'required' => true
            ))
            ->add('amount', NumberType::class);
    }

    public function getName()
    {
        return 'movementaccount';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pimx\ModelBundle\Entity\MovementAccount',
        ));
    }
}