<?php

namespace App\Form;

use App\Entity\AccountBalance;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
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
                'label' => 'Code',
            ])

            ->add('accountt', EntityType::class, [
                'class' => AccountBalance::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->findAccountByStatus(0);
                },
                'choice_label' => 'name',
                'placeholder' => 'Choose an Account',
                'mapped' => false
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

                $data = $event->getData();
                $form = $event->getForm();
                $account = $form->get("account")->getData();

                $accountType = null === $account ? [] : $account->getAccountType();

                dd($accountType);
                // Add the Neighborhoods field with the properly data
                $form->add('accountType', EntityType::class, [
                    'class' => AccountBalance::class,
                    'choices' => $accountType,
                    'choice_label' => 'name',
                    'placeholder' => 'Choose an AccountType',
                    'mapped' => false
                ]);
            })
            ->add('save', SubmitType::class);
    }






    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountBalance::class,
        ]);
    }
}
