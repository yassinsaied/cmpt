<?php

namespace App\Form;

use App\Entity\AccountBalance;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\AccountBalanceRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountBalanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Account Name',
            ])

            ->add('code', TextType::class, [
                'required' => true,
                'label' => 'Account Name',
            ])

            ->add('account', EntityType::class, [
                'class' => AccountBalance::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAccountByCode(100);
                },
                'choice_label' => 'name',
            ])

            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountBalance::class,
        ]);
    }
}
