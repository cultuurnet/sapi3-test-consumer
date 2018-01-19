<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\Coordinates;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class CoordinatesParameterTransformer extends SearchQueryParameterTransformer
{

    /**
     * Transform's a string, number or date to a Search Query Parameter
     *
     * @param mixed $value
     * @return ParameterInterface|null
     * @throws TransformationFailedException if object (parameter) is not found.
     */
    public function reverseTransform($value) {
        var_dump($value);
        if (!$value) {
            return;
        }
        $coords = explode(',', $value);
        $parameter = new Coordinates($coords[0], $coords[1]);

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'The postalCode "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}