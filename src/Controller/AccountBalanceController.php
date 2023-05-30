<?php

namespace App\Controller;

use App\Entity\AccountBalance;
use App\Form\AccountBalanceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountBalanceController extends AbstractController
{
    #[Route('/account/create', name: 'cmpt_create_account')]
    public function createAccount(Request $request): Response
    {


        $form = $this->createForm(AccountBalanceType::class, new AccountBalance());
        $form->handleRequest($request);

        return $this->render('account_balance/create.html.twig', [
            'controller_name' => 'AccountBalanceController',
        ]);
    }
}
