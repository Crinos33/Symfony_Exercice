<?php

namespace App\Form;

use App\Entity\Listitem;
use App\Form\DataTransformer\TasklistToNumberTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use App\Entity\Tasklist;
class ListitemType extends AbstractType
{
    protected $em;
    public function __construct(EntityManager $em){
        $this->em =$em;
}
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new TasklistToNumberTransformer($this->em);
        $builder
            ->add('label')
            ->add('tasklist', HiddenType::class)
        ;
        $builder->get('tasklist')
            ->addModelTransformer($transformer);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Listitem::class,
        ]);
    }
}
