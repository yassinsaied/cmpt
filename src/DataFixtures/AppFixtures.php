<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Entity\AccountBalance;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{

    const ACCOUNT = [
        "Actifs" => ["Actifs non courants ", "Actifs courants"],
        "Passive" => ["Capitaux propres", "Passive courants"]

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

        $accountBalance = new AccountBalance();

        foreach (self::ACCOUNT as $key => $value) {
            $accountBalance->setAccount($key);
            $accountBalance->addAccountType($value);
        }
        $manager->persist($accountBalance);
        $manager->flush();
    }
}
