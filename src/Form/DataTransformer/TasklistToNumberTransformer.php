<?php

namespace App\Form\DataTransformer;

use App\Entity\Tasklist;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;

class TasklistToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (tasklist) to a string (number).
     *
     * @param  Tasklist|null $tasklist
     * @return string
     */
    public function transform($tasklist)
    {
        if (null === $tasklist) {
            return '';
        }

        return $tasklist->getId();
    }

    /**
     * Transforms a string (number) to an object (tasklist).
     *
     * @param  string $tasklistNumber
     * @return Tasklist|null
     * @throws TransformationFailedException if object (tasklist) is not found.
     */
    public function reverseTransform($tasklistNumber)
    {
        // no issue number? It's optional, so that's ok
        if (!$tasklistNumber) {
            return;
        }

        $tasklist = $this->entityManager
            ->getRepository(Tasklist::class)
            // query for the issue with this id
            ->find($tasklistNumber)
        ;

        if (null === $tasklist) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An tasklist with number "%s" does not exist!',
                $tasklistNumber
            ));
        }

        return $tasklist;
    }
}