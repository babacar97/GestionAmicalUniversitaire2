<?php

namespace App\Form;

use App\Entity\Budget;
use App\Entity\Depense;
use App\Repository\BudgetRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('montant')
            ->add('date')
            ->add('auteur')
            ->add('commentaires')
            ->add('justificatif')
            ->add('budget', HiddenType::class);
        // ->add('budget', EntityType::class, [
        // 'type' => HiddenType::class,
        // 'class' => Budget::class,
        // 'choice_label' => 'id',
        // 'mapped' => false,
        // 'query_builder' => function (BudgetRepository $budgetRepository) {
        //     return $budgetRepository->createQueryBuilder('id');
        // }
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depense::class,
        ]);
    }
}
