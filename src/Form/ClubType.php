<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\League;
use App\Entity\Country;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                "label" => "nom du club",
                "required" => true,
            ])
            ->add('yearAt', null, [
                "widget" => 'single_text',
                "required" => true,
            ])
            ->add('image', TextType::class, [
                "label" => "maillot du club",
                "required" => true,
            ])
            ->add('price', TextType::class, [
                "label" => "prix du maillot",
                "required" => true,
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'label',
            ])
            ->add('league', EntityType::class, [
                'class' => League::class,
                'choice_label' => 'label',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => true,
                "expanded" => true,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
