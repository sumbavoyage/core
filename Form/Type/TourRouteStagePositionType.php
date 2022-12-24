<?php

namespace Svs\Core\Form\Type;

use Svs\Core\Entity\RouteStage;
use Svs\Core\Entity\Tour;
use Svs\Core\Repository\RouteStageRepository;
use Svs\Core\Repository\TourRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Doctrine\ORM\EntityRepository;

class TourRouteStagePositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tour', EntityType::class, [
                'class' => Tour::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.reference', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('routeStage', EntityType::class, [
                'class' => RouteStage::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('rs')
                        ->orderBy('rs.id', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('position')
        ;
    }
}
