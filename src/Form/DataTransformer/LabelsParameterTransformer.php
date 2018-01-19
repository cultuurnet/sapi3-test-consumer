<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\Labels;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class LabelsParameterTransformer extends SearchQueryParameterTransformer {

    public function transform($parameter) {
        if (null === $parameter) {
            return array();
        }

        $labels = array();

        foreach ($parameter as $label) {
            $labels[] = $label->getValue();
        }

        return $labels;
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
        $labels = explode("\n", $value);
        foreach ($labels as $label) {
            $parameter[] = new Labels($label);
        }

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'Labels "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}
