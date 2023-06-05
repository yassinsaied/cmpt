<?php

namespace App\Controller;

use App\Entity\AccountBalance;
use App\Form\AccountBalanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountBalanceController extends AbstractController
{
    #[Route('/account/create', name: 'cmpt_create_account')]
    public function createAccount(Request $request , EntityManagerInterface $entityManager): Response
    {
        $accountBalance = new AccountBalance() ;

        $form = $this->createForm(AccountBalanceType::class, $accountBalance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $accountBalance->setStatus(3);
            $accountBalance->setAccount($form->get('subAccount')->getData());
            $entityManager->persist( $accountBalance) ;
            $entityManager->flush() ;
        }

        return $this->render('account_balance/create.html.twig', [
             "formCreateAccount" =>  $form->createView() 
        ]);
    }


}
