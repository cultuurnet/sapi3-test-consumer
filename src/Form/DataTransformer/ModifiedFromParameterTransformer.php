<?php

namespace TestConsumer\Form\DataTransformer;

use CultuurNet\SearchV3\Parameter\ModifiedFrom;
use Symfony\Component\Form\Exception\TransformationFailedException;
use CultuurNet\SearchV3\ParameterInterface;

class ModifiedFromParameterTransformer extends SearchQueryParameterTransformer
{

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

        $parameter = new ModifiedFrom(new \DateTime($value));

        if (null === $value) {
            throw new TransformationFailedException(sprintf(
                'ModifiedFrom "%s" does not exist!',
                $value
            ));
        }

        return $parameter;
    }
}
