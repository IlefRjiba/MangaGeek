<?php

namespace App\Form;

use App\Entity\Manga;
use App\Entity\Mangatheque;
use App\Entity\Member;
use App\Repository\MangaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MangathequeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);    
        $mangatheque = $options['data'] ?? null;
        $member = $mangatheque->getMember();

        $builder
            ->add('description')
            ->add('publiee')
            
            ->add('member', EntityType::class, [
                    'class' => Member::class,
                    'choice_label' => 'id',
                    'disabled' => true,
                ])

            ->add('mangas', EntityType::class, [
                    'class' => Manga::class,
                    'choice_label' => 'id',
                    'multiple' => true,
                    'query_builder' => function (MangaRepository $er) use ($member) {
                        return $er->createQueryBuilder('o')
                            ->leftJoin('o.mangashelf', 'i') // Adjusted the field to match your relationships
                            ->leftJoin('i.membre', 'm')
                            ->andWhere('m.id = :memberId')
                            ->setParameter('memberId', $member ? $member->getId() : null);
                            },
                ]);
                ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mangatheque::class,
        ]);
    }
}
