<?php

namespace App\Command;

use App\Entity\User;
use App\Helper\Random;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{
    private $em;
    private $passwordHasher;
    public function __construct(EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Enter email id')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if ($email) {
            $io->note(sprintf('You passed an argument: %s', $email));
        }else{
            $email= Random::generateRandomString(5)."@gmail.com";
        }
        $user->setEmail($email);
        $this->createUser($user);

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success("User created successfully");
        $io->success("Email: ".$email." Password: 123");

        return Command::SUCCESS;
    }
    private function createUser(User $user){
        $user->setPassword($this->passwordHasher->hashPassword($user,"123"));
        $user->setRoles(["ROLE_USER"]);
        $user->setStatus(true);
        $this->em->persist($user);
        $this->em->flush();
    }
}
