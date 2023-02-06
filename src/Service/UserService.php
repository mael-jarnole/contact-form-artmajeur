<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements EventSubscriberInterface
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        UserRepository              $userRepository,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => "onRequest",
        ];
    }

    public function onRequest()
    {
        // Ensure the admin user was created
        if (sizeof($this->userRepository->findAll()) == 0) {
            $adminUser = new User();
            $adminUser->setEmail("admin@artmajeur.com");
            $adminUser->setRoles(["ROLE_ADMIN"]);
            $plaintextPassword = "admin";
            $hashedPassword = $this->passwordHasher->hashPassword(
                $adminUser,
                $plaintextPassword
            );
            $adminUser->setPassword($hashedPassword);
            $this->userRepository->save($adminUser, true);
        }
    }
}