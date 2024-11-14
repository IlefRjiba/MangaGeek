<?php

namespace App\Form;

use App\Entity\Manga;
use App\Entity\Mangatheque;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangathequeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('publiee')
            ->add('member', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'id',
            ])
            ->add('mangas', EntityType::class, [
                'class' => Manga::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mangatheque::class,
        ]);
    }
}
