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


            ->add('save', SubmitType::class);

        $formModifier = function (FormInterface $form, AccountBalance $account = null) {
            $subAccount = $account === null ? [] : $account->getAccountType();

            $form->add('subAccount', EntityType::class, [
                'class' => AccountBalance::class,
                'choice_label' => 'name',
                'choices' => $subAccount,
                'placeholder' => 'Choose an type Account',
                "mapped" => false
            ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $gAccount = $event->getForm()->get('accountt')->getData();
                $formModifier($event->getForm(), $gAccount);
            }
        );

        $builder->get('accountt')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $globalAccount = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $globalAccount);
            }
        );
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountBalance::class,
        ]);
    }
}
