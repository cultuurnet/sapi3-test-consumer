<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\Facet;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class FacetCountsParameterTransformer extends SearchQueryParameterTransformer {

    public function transform($parameter) {

        $facets = array();

        if ($parameter !== null) {
            foreach ($parameter as $facet) {
                $facets[] = $facet->getValue();
            }
        }

        return $facets;
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

        foreach ($value as $facet) {
            $parameter[] = new Facet($facet);
        }

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'Creator "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}
