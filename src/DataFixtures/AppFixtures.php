<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Entity\AccountBalance;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{

    const ACCOUNT = [
        "Actifs" => [
            201 =>  "Actifs non courants",
            202 => "Actifs courants"
        ],
        "Passive" => [
            203 =>  "Capitaux propres",
            204 =>  "Passive courants"
        ]

    ];

    // public function load(ObjectManager $manager): void
    // {
    //     // $product = new Product();
    //     // $manager->persist($product);
    //     UserFactory::createOne(['email' => 'admin@admin.com']);
    //     UserFactory::createMany(10);
    //     $manager->flush();
    // }


    function load(ObjectManager $manager): void
    {



        foreach (self::ACCOUNT as $key => $value) {
            $accountBalance = new AccountBalance();
            $accountBalance->setName($key);
            $accountBalance->setCode(100);
            $accountBalance->setStatus(0);
            $manager->persist($accountBalance);
            $this->addReference($key, $accountBalance);
            foreach ($value as $subKey => $subValue) {
                $subAccountBalance = new AccountBalance();
                $subAccountBalance->setName($subValue);
                $subAccountBalance->setCode($subKey);
                $subAccountBalance->setStatus(1);
                $subAccountBalance->setAccount($this->getReference($key));
                $manager->persist($subAccountBalance);
            }
        }

        $manager->flush();
    }
}
