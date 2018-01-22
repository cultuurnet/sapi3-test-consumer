<?php

namespace TestConsumer\Form;

use CultuurNet\SearchV3\Parameter\Regions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use TestConsumer\Form\DataTransformer\DateFromParameterTransformer;
use TestConsumer\Form\DataTransformer\DateToParameterTransformer;
use TestConsumer\Form\DataTransformer\AddressCountryParameterTransformer;
use TestConsumer\Form\DataTransformer\PostalCodeParameterTransformer;
use TestConsumer\Form\DataTransformer\MinAgeParameterTransformer;
use TestConsumer\Form\DataTransformer\MaxAgeParameterTransformer;
use TestConsumer\Form\DataTransformer\AudienceTypeParameterTransformer;
use TestConsumer\Form\DataTransformer\CalendarTypeParameterTransformer;
use TestConsumer\Form\DataTransformer\CreatorParameterTransformer;
use TestConsumer\Form\DataTransformer\FacetCountsParameterTransformer;
use TestConsumer\Form\DataTransformer\CoordinatesParameterTransformer;
use TestConsumer\Form\DataTransformer\DistanceParameterTransformer;
use TestConsumer\Form\DataTransformer\IdParameterTransformer;
use TestConsumer\Form\DataTransformer\LocationIdParameterTransformer;
use TestConsumer\Form\DataTransformer\OrganizerIdParameterTransformer;
use TestConsumer\Form\DataTransformer\LabelsParameterTransformer;
use TestConsumer\Form\DataTransformer\LanguagesParameterTransformer;
use TestConsumer\Form\DataTransformer\MediaObjectParameterTransformer;
use TestConsumer\Form\DataTransformer\PriceParameterTransformer;
use TestConsumer\Form\DataTransformer\MinPriceParameterTransformer;
use TestConsumer\Form\DataTransformer\MaxPriceParameterTransformer;
use TestConsumer\Form\DataTransformer\RegionsParameterTransformer;
use TestConsumer\Form\DataTransformer\TermIdsParameterTransformer;

use TestConsumer\Form\DataTransformer\AvailableFromParameterTransformer;
use TestConsumer\Form\DataTransformer\AvailableToParameterTransformer;
use TestConsumer\Form\DataTransformer\CreatedFromParameterTransformer;
use TestConsumer\Form\DataTransformer\CreatedToParameterTransformer;
use TestConsumer\Form\DataTransformer\ModifiedFromParameterTransformer;
use TestConsumer\Form\DataTransformer\ModifiedToParameterTransformer;

class QueryForm extends AbstractType
{
    private $addressCountryTransformer;
    private $postalCodeTransformer;
    private $minAgeTransformer;
    private $maxAgeTransformer;
    private $audienceTypeTransformer;
    private $dateFromTypeTransformer;
    private $dateToTypeTransformer;
    private $calendarTypeTransformer;
    private $creatorTypeTransformer;
    private $facetCountsTypeTransformer;
    private $coordinatesTypeTransformer;
    private $distanceTypeTransformer;
    private $idTypeTransformer;
    private $locationIdTypeTransformer;
    private $organizerIdTypeTransformer;
    private $labelsTypeTransformer;
    private $languagesTypeTransformer;
    private $mediaObjectTypeTransformer;
    private $priceTypeTransformer;
    private $minPriceTypeTransformer;
    private $maxPriceTypeTransformer;
    private $regionsTypeTransformer;
    private $termIdsTypeTransformer;

    private $availableFromTypeTransformer;
    private $availableToTypeTransformer;
    private $createdFromTypeTransformer;
    private $createdToTypeTransformer;
    private $modifiedFromTypeTransformer;
    private $modifiedToTypeTransformer;

    public function __construct(AddressCountryParameterTransformer $addressCountryTransformer,
        PostalCodeParameterTransformer $postalCodeTransformer,
        MinAgeParameterTransformer $minAgeParameterTransformer,
        MaxAgeParameterTransformer $maxAgeParameterTransformer,
        AudienceTypeParameterTransformer $audienceTypeParameterTransformer,
        DateFromParameterTransformer $dateFromParameterTransformer,
        DateToParameterTransformer $dateToParameterTransformer,
        CalendarTypeParameterTransformer $calendarParameterTransformer,
        CreatorParameterTransformer $creatorParameterTransformer,
        FacetCountsParameterTransformer $facetCountsParameterTransformer,
        CoordinatesParameterTransformer $coordinatesParameterTransformer,
        DistanceParameterTransformer $distanceParameterTransformer,
        IdParameterTransformer $idParameterTransformer,
        LocationIdParameterTransformer $locationIdParameterTransformer,
        OrganizerIdParameterTransformer $organizerIdParameterTransformer,
        LabelsParameterTransformer $labelsParameterTransformer,
        LanguagesParameterTransformer $languagesParameterTransformer,
        MediaObjectParameterTransformer $mediaObjectParameterTransformer,
        PriceParameterTransformer $priceParameterTransformer,
        MinPriceParameterTransformer $minPriceParameterTransformer,
        MaxPriceParameterTransformer $maxPriceParameterTransformer,
        RegionsParameterTransformer $regionsParameterTransformer,
        TermIdsParameterTransformer $termIdsParameterTransformer,
        AvailableFromParameterTransformer $availableFromParameterTransformer,
        AvailableToParameterTransformer $availableToParameterTransformer,
        CreatedFromParameterTransformer $createdFromParameterTransformer,
        CreatedToParameterTransformer $createdToParameterTransformer,
        ModifiedFromParameterTransformer $modifiedFromParameterTransformer,
        ModifiedToParameterTransformer $modifiedToParameterTransformer)
    {
        $this->addressCountryTransformer = $addressCountryTransformer;
        $this->postalCodeTransformer = $postalCodeTransformer;
        $this->minAgeTransformer = $minAgeParameterTransformer;
        $this->maxAgeTransformer = $maxAgeParameterTransformer;
        $this->audienceTypeTransformer = $audienceTypeParameterTransformer;
        $this->dateFromTypeTransformer = $dateFromParameterTransformer;
        $this->dateToTypeTransformer = $dateToParameterTransformer;
        $this->calendarTypeTransformer = $calendarParameterTransformer;
        $this->creatorTypeTransformer = $creatorParameterTransformer;
        $this->facetCountsTypeTransformer = $facetCountsParameterTransformer;
        $this->coordinatesTypeTransformer = $coordinatesParameterTransformer;
        $this->distanceTypeTransformer = $distanceParameterTransformer;
        $this->idTypeTransformer = $idParameterTransformer;
        $this->locationIdTypeTransformer = $locationIdParameterTransformer;
        $this->organizerIdTypeTransformer = $organizerIdParameterTransformer;
        $this->labelsTypeTransformer = $labelsParameterTransformer;
        $this->languagesTypeTransformer = $languagesParameterTransformer;
        $this->mediaObjectTypeTransformer = $mediaObjectParameterTransformer;
        $this->priceTypeTransformer = $priceParameterTransformer;
        $this->minPriceTypeTransformer = $minPriceParameterTransformer;
        $this->maxPriceTypeTransformer = $maxPriceParameterTransformer;
        $this->regionsTypeTransformer = $regionsParameterTransformer;
        $this->termIdsTypeTransformer = $termIdsParameterTransformer;

        $this->availableFromTypeTransformer = $availableFromParameterTransformer;
        $this->availableToTypeTransformer = $availableToParameterTransformer;
        $this->createdFromTypeTransformer = $createdFromParameterTransformer;
        $this->createdToTypeTransformer = $createdToParameterTransformer;
        $this->modifiedFromTypeTransformer = $modifiedFromParameterTransformer;
        $this->modifiedToTypeTransformer = $modifiedToParameterTransformer;
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
            ->add('createdFrom', TextType::class, array(
                'label' => 'Created From',
                'required' => false
            ))
            ->add('createdTo', TextType::class, array(
                'label' => 'Created To',
                'required' => false
            ))
            ->add('modifiedFrom', TextType::class, array(
                'label' => 'Modified From',
                'required' => false
            ))
            ->add('modifiedTo', TextType::class, array(
                'label' => 'Modified To',
                'required' => false
            ))
            ->add('creator', TextType::class, array(
                'label' => 'Creator',
                'required' => false
            ))
            ->add('facetCounts', ChoiceType::class, array(
                'choices' => array(
                    'regions' => 'regions',
                    'types' => 'types',
                    'themes' => 'themes',
                    'facilities' => 'facilities'
                ),
                'label' => 'Facets',
                'required' => false,
                'expanded' => true,
                'multiple' => true
            ))
            ->add('coordinates', TextType::class, array(
                'label' => 'Coordinates',
                'required' => false
            ))
            ->add('distance', NumberType::class, array(
                'label' => 'Distance',
                'scale' => 0,
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
            ->add('labels', TextType::class, array(
                'label' => 'Labels',
                'required' => false,
                'attr' => array(
                    'data-role' => 'tagsinput'
                ),
            ))
            ->add('languages', ChoiceType::class, array(
                'choices' => array(
                    'nl' => 'nl',
                    'fr' => 'fr',
                    'en' => 'en',
                    'de' => 'de'
                ),
                'label' => 'Languages',
                'required' => false,
                'expanded' => true,
                'multiple' => true
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
            ->add('regions', TextType::class, array(
                'label' => 'Regions',
                'required' => false,
                'attr' => array(
                    'data-role' => 'tagsinput'
                )
            ))
            ->add('termIds', TextType::class, array(
                'label' => 'Term ID\'s',
                'required' => false,
                'attr' => array(
                    'data-role' => 'tagsinput'
                )
            ))
            ->add('termLabels', TextType::class, array(
                'label' => 'Term Labels',
                'required' => false,
                'attr' => array(
                    'data-role' => 'tagsinput'
                )
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
        $builder->get('calendarType')->addModelTransformer($this->calendarTypeTransformer);
        $builder->get('creator')->addModelTransformer($this->creatorTypeTransformer);
        $builder->get('facetCounts')->addModelTransformer($this->facetCountsTypeTransformer);
        $builder->get('coordinates')->addModelTransformer($this->coordinatesTypeTransformer);
        $builder->get('distance')->addModelTransformer($this->distanceTypeTransformer);
        $builder->get('id')->addModelTransformer($this->idTypeTransformer);
        $builder->get('locationId')->addModelTransformer($this->locationIdTypeTransformer);
        $builder->get('organizerId')->addModelTransformer($this->organizerIdTypeTransformer);
        $builder->get('labels')->addModelTransformer($this->labelsTypeTransformer);
        $builder->get('languages')->addModelTransformer($this->languagesTypeTransformer);
        $builder->get('hasMediaObject')->addModelTransformer($this->mediaObjectTypeTransformer);
        $builder->get('price')->addModelTransformer($this->priceTypeTransformer);
        $builder->get('minPrice')->addModelTransformer($this->minPriceTypeTransformer);
        $builder->get('maxPrice')->addModelTransformer($this->maxPriceTypeTransformer);
        $builder->get('regions')->addModelTransformer($this->regionsTypeTransformer);
        $builder->get('termIds')->addModelTransformer($this->termIdsTypeTransformer);

        $builder->get('availableFrom')->addModelTransformer($this->availableFromTypeTransformer);
        $builder->get('availableTo')->addModelTransformer($this->availableToTypeTransformer);
        $builder->get('createdFrom')->addModelTransformer($this->createdFromTypeTransformer);
        $builder->get('createdTo')->addModelTransformer($this->createdToTypeTransformer);
        $builder->get('modifiedFrom')->addModelTransformer($this->modifiedFromTypeTransformer);
        $builder->get('modifiedTo')->addModelTransformer($this->modifiedToTypeTransformer);
    }
}