<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Priority;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\ImageType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('done')
            ->add('priority',EntityType::class, array(
                'class' => Priority::class,
                'choice_label' => function($priority){
                    return $priority->getName();
                }

            ))
            ->add('image',ImageType::Class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
