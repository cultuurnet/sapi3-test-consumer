<?php

namespace TestConsumer\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use TestConsumer\Form\DataTransformer\AddressCountryParameterTransformer;
use TestConsumer\Form\DataTransformer\PostalCodeParameterTransformer;
use TestConsumer\Form\DataTransformer\MinAgeParameterTransformer;
use TestConsumer\Form\DataTransformer\MaxAgeParameterTransformer;

class QueryForm extends AbstractType
{
    private $addressCountryTransformer;
    private $postalCodeTransformer;
    private $minAgeTransformer;
    private $maxAgeTransformer;

    public function __construct(AddressCountryParameterTransformer $addressCountryTransformer,
        PostalCodeParameterTransformer $postalCodeTransformer,
        MinAgeParameterTransformer $minAgeParameterTransformer,
        MaxAgeParameterTransformer $maxAgeParameterTransformer)
    {
        $this->addressCountryTransformer = $addressCountryTransformer;
        $this->postalCodeTransformer = $postalCodeTransformer;
        $this->minAgeTransformer = $minAgeParameterTransformer;
        $this->maxAgeTransformer = $maxAgeParameterTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom', DateTimeType::class, array(
                'label' => 'Date From',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('dateTo', DateTimeType::class, array(
                'label' => 'Date To',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('addressCountry', TextType::class, array(
                'label' => 'Address Country',
                'required' => false
            ))
            ->add('postalCode', TextType::class, array(
                'label' => 'Postal Code',
                'required' => false
            ))
            ->add('minAge', NumberType::class, array(
                'label' => 'Min Age',
                'scale' => 0,
                'required' => false
            ))
            ->add('maxAge', NumberType::class, array(
                'label' => 'Max Age',
                'scale' => 0,
                'required' => false
            ))
            ->add('audienceType', ChoiceType::class, array(
                'choices' => array(
                    'everyone' => 'everyone',
                    'members' => 'members',
                    'education' => 'education'
                ),
                'label' => 'Audience Type',
                'required' => false
            ))
            ->add('availableFrom', DateTimeType::class, array(
                'label' => 'Available From',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('availableTo', DateTimeType::class, array(
                'label' => 'Available To',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('calendarType', ChoiceType::class, array(
                'choices' => array(
                    'single' => 'single',
                    'multiple' => 'multiple',
                    'periodic' => 'periodic',
                    'permanent' => 'permanent'
                ),
                'label' => 'Calendar Type',
                'required' => false
            ))
            ->add('createdFrom', DateTimeType::class, array(
                'label' => 'Created From',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('createdTo', DateTimeType::class, array(
                'label' => 'Created To',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('modifiedFrom', DateTimeType::class, array(
                'label' => 'Modified From',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('modifiedTo', DateTimeType::class, array(
                'label' => 'Modified To',
                'widget' => 'single_text',
                'format' => \DateTime::ATOM,
                'required' => false
            ))
            ->add('creator', TextType::class, array(
                'label' => 'Creator',
                'required' => false
            ))
            ->add('facetCounts', TextareaType::class, array(
                'label' => 'Facets',
                'required' => false
            ))
            ->add('coordinates', TextType::class, array(
                'label' => 'Coordinates',
                'required' => false
            ))
            ->add('distance', TextType::class, array(
                'label' => 'Distance',
                'required' => false
            ))
            ->add('id', TextType::class, array(
                'label' => 'ID',
                'required' => false
            ))
            ->add('locationId', TextType::class, array(
                'label' => 'Location ID',
                'required' => false
            ))
            ->add('organizerId', TextType::class, array(
                'label' => 'Organizer ID',
                'required' => false
            ))
            ->add('labels', TextareaType::class, array(
                'label' => 'Labels',
                'required' => false
            ))
            ->add('languages', TextareaType::class, array(
                'label' => 'Languages',
                'required' => false
            ))
            ->add('hasMediaObject', CheckboxType::class, array(
                'label' => 'Has Media Object',
                'required' => false
            ))
            ->add('price', NumberType::class, array(
                'label' => 'Price',
                'scale' => 2,
                'required' => false
            ))
            ->add('minPrice', NumberType::class, array(
                'label' => 'Minimum Price',
                'scale' => 2,
                'required' => false
            ))
            ->add('maxPrice', NumberType::class, array(
                'label' => 'Maximum Price',
                'scale' => 2,
                'required' => false
            ))
            ->add('regions', TextareaType::class, array(
                'label' => 'Regions',
                'required' => false
            ))
            ->add('termIds', TextareaType::class, array(
                'label' => 'Term ID\'s',
                'required' => false
            ))
            ->add('termLabels', TextareaType::class, array(
                'label' => 'Term Labels',
                'required' => false
            ))
            ->add('uitpas', CheckboxType::class, array(
                'label' => 'UiTPAS',
                'required' => false
            ))
            ->add('workflowStatus', ChoiceType::class, array(
                'choices' => array(
                    'DRAFT' => 'draft',
                    'READY_FOR_VALIDATION' => 'ready for validation',
                    'APPROVED' => 'approved',
                    'REJECTED' => 'rejected',
                    'DELETED' => 'deleted'
                ),
                'label' => 'Calendar Type',
                'required' => false
            ))
        ;


        $builder->get('addressCountry')->addModelTransformer($this->addressCountryTransformer);
        $builder->get('postalCode')->addModelTransformer($this->postalCodeTransformer);
        $builder->get('minAge')->addModelTransformer($this->minAgeTransformer);
        $builder->get('maxAge')->addModelTransformer($this->maxAgeTransformer);
    }
}