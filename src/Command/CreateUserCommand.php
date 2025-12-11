<?php

namespace App\Command;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates or updates a user',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private MembreRepository $membreRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username');
        $this->addArgument('password', InputArgument::REQUIRED, 'The password');
        $this->addArgument('role', InputArgument::OPTIONAL, 'The role (default: ROLE_USER)', 'ROLE_USER');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $role = $input->getArgument('role');

        $user = $this->membreRepository->findOneBy(['username' => $username]);

        if (!$user) {
            $user = new Membre();
            $user->setUsername($username);
            $user->setNomMembre(ucfirst($username));
            $user->setPrenomMembre('User');
            $user->setMailMembre($username . '@agora.fr');
            $user->setTelMembre('0123456789');
            $output->writeln("Creating new user '$username'...");
        } else {
            $output->writeln("Updating existing user '$username'...");
        }

        $user->setRoles([$role]);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln("User '$username' successfully updated with password: '$password'");
        $output->writeln('Hash: ' . $hashedPassword);

        return Command::SUCCESS;
    }
}
