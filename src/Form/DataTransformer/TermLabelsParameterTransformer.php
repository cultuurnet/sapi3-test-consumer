<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\TermLabels;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class TermLabelsParameterTransformer extends SearchQueryParameterTransformer {

    public function transform($parameter) {
        if (null === $parameter) {
            return array();
        }

        $termLabels = array();

        foreach ($parameter as $termLabel) {
            $termLabels[] = $termLabel->getValue();
        }

        return $termLabels;
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
        $termLabels = explode(",", $value);
        foreach ($termLabels as $termLabel) {
            $parameter[] = new TermLabels($termLabel);
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
