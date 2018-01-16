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

use TestConsumer\Form\DataTransformer\DateFromParameterTransformer;
use TestConsumer\Form\DataTransformer\DateToParameterTransformer;
use TestConsumer\Form\DataTransformer\AddressCountryParameterTransformer;
use TestConsumer\Form\DataTransformer\PostalCodeParameterTransformer;
use TestConsumer\Form\DataTransformer\MinAgeParameterTransformer;
use TestConsumer\Form\DataTransformer\MaxAgeParameterTransformer;
use TestConsumer\Form\DataTransformer\AudienceTypeParameterTransformer;
use TestConsumer\Form\DataTransformer\AvailableFromParameterTransformer;
use TestConsumer\Form\DataTransformer\AvailableToParameterTransformer;

class QueryForm extends AbstractType
{
    private $addressCountryTransformer;
    private $postalCodeTransformer;
    private $minAgeTransformer;
    private $maxAgeTransformer;
    private $audienceTypeTransformer;
    private $dateFromTypeTransformer;
    private $dateToTypeTransformer;

    private $availableFromTypeTransformer;
    private $availableToTypeTransformer;

    public function __construct(AddressCountryParameterTransformer $addressCountryTransformer,
        PostalCodeParameterTransformer $postalCodeTransformer,
        MinAgeParameterTransformer $minAgeParameterTransformer,
        MaxAgeParameterTransformer $maxAgeParameterTransformer,
        AudienceTypeParameterTransformer $audienceTypeParameterTransformer,
        DateFromParameterTransformer $dateFromParameterTransformer,
        DateToParameterTransformer $dateToParameterTransformer,
        AvailableFromParameterTransformer $availableFromParameterTransformer,
        AvailableToParameterTransformer $availableToParameterTransformer)
    {
        $this->addressCountryTransformer = $addressCountryTransformer;
        $this->postalCodeTransformer = $postalCodeTransformer;
        $this->minAgeTransformer = $minAgeParameterTransformer;
        $this->maxAgeTransformer = $maxAgeParameterTransformer;
        $this->audienceTypeTransformer = $audienceTypeParameterTransformer;
        $this->dateFromTypeTransformer = $dateFromParameterTransformer;
        $this->dateToTypeTransformer = $dateToParameterTransformer;
        $this->availableFromTypeTransformer = $availableFromParameterTransformer;
        $this->availableToTypeTransformer = $availableToParameterTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom', TextType::class, array(
                'label' => 'Date From',
                'required' => false,
            ))
            ->add('dateTo', TextType::class, array(
                'label' => 'Date To',
                'required' => false,
            ))
            ->add('addressCountry', TextType::class, array(
                'label' => 'Address Country',
                'required' => false
            ))
            ->add('postalCode', TextType::class, array(
                'label' => 'Postal Code',
                'required' => false
            ))
            ->add('minAge', TextType::class, array(
                'label' => 'Min Age',
                'required' => false
            ))
            ->add('maxAge', TextType::class, array(
                'label' => 'Max Age',
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
            ->add('availableFrom', TextType::class, array(
                'label' => 'Available From',
                'required' => false
            ))
            ->add('availableTo', TextType::class, array(
                'label' => 'Available To',
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

        $builder->get('dateFrom')->addModelTransformer($this->dateFromTypeTransformer);
        $builder->get('dateTo')->addModelTransformer($this->dateToTypeTransformer);
        $builder->get('addressCountry')->addModelTransformer($this->addressCountryTransformer);
        $builder->get('postalCode')->addModelTransformer($this->postalCodeTransformer);
        $builder->get('minAge')->addModelTransformer($this->minAgeTransformer);
        $builder->get('maxAge')->addModelTransformer($this->maxAgeTransformer);
        $builder->get('audienceType')->addModelTransformer($this->audienceTypeTransformer);

        $builder->get('availableFrom')->addModelTransformer($this->availableFromTypeTransformer);
        $builder->get('availableTo')->addModelTransformer($this->availableToTypeTransformer);
    }
}