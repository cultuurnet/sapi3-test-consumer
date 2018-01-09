<?php

namespace TestConsumer\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CredentialsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('endpoint', ChoiceType::class, array(
                'choices' => array(
                    'productie' => 'http://search.uitdatabank.be',
                    'test' => 'http://search-test.uitdatabank.be'
                ),
                'label' => 'API endpoint'
            ))
            ->add('key', TextType::class, array(
                'label' => 'API key'
            ))
        ;
    }
}