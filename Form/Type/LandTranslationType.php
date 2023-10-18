<?php

namespace Svs\Core\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class LandTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('introText1', TextType::class)
            ->add('introText2', TextType::class)
            ->add('introText3', TextType::class)
            ->add('faqTitle1', TextType::class)
            ->add('faqText1', CKEditorType::class)
            ->add('faqTitle2', TextType::class)
            ->add('faqText2', CKEditorType::class)
            ->add('faqTitle3', TextType::class)
            ->add('faqText3', CKEditorType::class)
            ->add('faqTitle4', TextType::class)
            ->add('faqText4', CKEditorType::class)
            ->add('faqTitle5', TextType::class)
            ->add('faqText5', CKEditorType::class)
            ->add('faqTitle6', TextType::class)
            ->add('faqText6', CKEditorType::class)
            ->add('description', CKEditorType::class)
            ->add('priceText', CKEditorType::class)
            ->add('locale', TextType::class)
        ;
    }
}
