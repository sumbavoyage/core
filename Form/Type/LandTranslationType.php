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
            ->add('slug', TextType::class)
            ->add('location', TextType::class)
            ->add('introText1', TextType::class)
            ->add('introText2', TextType::class)
            ->add('introText3', TextType::class)
            ->add('faqTitle1', TextType::class, ['required' => false])
            ->add('faqText1', CKEditorType::class, ['required' => false])
            ->add('faqTitle2', TextType::class, ['required' => false])
            ->add('faqText2', CKEditorType::class, ['required' => false])
            ->add('faqTitle3', TextType::class, ['required' => false])
            ->add('faqText3', CKEditorType::class, ['required' => false])
            ->add('faqTitle4', TextType::class, ['required' => false])
            ->add('faqText4', CKEditorType::class, ['required' => false])
            ->add('faqTitle5', TextType::class, ['required' => false])
            ->add('faqText5', CKEditorType::class, ['required' => false])
            ->add('faqTitle6', TextType::class, ['required' => false])
            ->add('faqText6', CKEditorType::class, ['required' => false])
            ->add('description', CKEditorType::class)
            ->add('priceText', CKEditorType::class)
            ->add('locale', TextType::class)
        ;
    }
}
