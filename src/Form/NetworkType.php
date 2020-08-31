<?php

namespace App\Form;

use App\Entity\Network;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address',TextType::class,['label'=>'Machine ip address'])
            ->add('network',TextType::class,['label'=>'Network address'])
            ->add('gateway',TextType::class,['label'=>'Gateway address'])
            ->add('dns1',TextType::class,['label'=>'DNS Server 1'])
            ->add('dns2',TextType::class,['required'=>false,'label'=>'DNS Server 2'])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Network::class,
        ]);
    }
}
