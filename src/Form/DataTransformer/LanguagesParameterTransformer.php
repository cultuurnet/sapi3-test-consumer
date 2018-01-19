<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\Languages;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class LanguagesParameterTransformer extends SearchQueryParameterTransformer {

    public function transform($parameter) {
        if (null === $parameter) {
            return array();
        }

        $languages = array();

        /*foreach ($parameter as $facet) {
            $languages[] = $facet->getValue();
        }*/

        return $languages;
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

        foreach ($value as $language) {
            $parameter[] = new Languages($language);
        }

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'Languages "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}
