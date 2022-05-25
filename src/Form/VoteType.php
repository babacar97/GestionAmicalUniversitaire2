<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Vote;
use App\Entity\Candidats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_vote')
            ->add('id_candidat', EntityType::class, [
                'class' => Candidats::class,
                'choice_label' => 'Id',
            ])
            ->add('id_user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'userName'
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
