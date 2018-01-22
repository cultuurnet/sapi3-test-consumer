<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\Regions;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class RegionsParameterTransformer extends SearchQueryParameterTransformer {

    public function transform($parameter) {
        if (null === $parameter) {
            return array();
        }

        $regions = array();

        foreach ($parameter as $label) {
            $labels[] = $label->getValue();
        }

        return $regions;
    }

    /**
     * Transform's a string, number or date to a Search Query Parameter
     *
     * @param mixed $value
     * @return array
     * @throws TransformationFailedException if object (parameter) is not found.
     */
    public function reverseTransform($value) {

        if (!$value) {
            return;
        }

        $parameter = array();
        $regions = explode(",", $value);
        foreach ($regions as $region) {
            $parameter[] = new Regions($region);
        }

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'Region "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}
