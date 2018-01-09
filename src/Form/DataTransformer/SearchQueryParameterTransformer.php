<?php

namespace TestConsumer\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

abstract class SearchQueryParameterTransformer implements DataTransformerInterface
{
    /**
     * Transform's a parameter to a string, number or date
     *
     * @param ParameterInterface|null $parameter
     * @return mixed
     */
    public function transform($parameter) {
        if (null === $parameter) {
            return '';
        }

        return $parameter->getValue();
    }
}
