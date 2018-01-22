<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\TermIds;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class TermIdsParameterTransformer extends SearchQueryParameterTransformer {

    public function transform($parameter) {
        if (null === $parameter) {
            return array();
        }

        $termIds = array();

        foreach ($parameter as $termId) {
            $termIds[] = $termId->getValue();
        }

        return $termIds;
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
        $termIds = explode(",", $value);
        foreach ($termIds as $termId) {
            $parameter[] = new TermIds($termId);
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
