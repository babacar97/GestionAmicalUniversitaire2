<?php

namespace App\Form;

use App\Entity\Campagne;
use App\Entity\Candidats;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('liste')
            ->add('idUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id'
            ])
            ->add('idCampagne', EntityType::class, [
                'class' => Campagne::class,
                'choice_label' => 'id'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidats::class,
        ]);
    }
}
