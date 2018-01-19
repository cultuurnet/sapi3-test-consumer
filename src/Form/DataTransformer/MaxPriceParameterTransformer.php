<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\MaxPrice;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class MaxPriceParameterTransformer extends SearchQueryParameterTransformer
{
    public function transform($parameter) {
        if (null === $parameter) {
            return 0;
        }

        return $parameter->getValue();
    }

    /**
     * Transform's a string, number or date to a Search Query Parameter
     *
     * @param mixed $value
     * @return ParameterInterface|null
     * @throws TransformationFailedException if object (parameter) is not found.
     */
    public function reverseTransform($value) {

        if (!$value) {
            return;
        }

        $parameter = new MaxPrice($value);

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'MaxPrice "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}
