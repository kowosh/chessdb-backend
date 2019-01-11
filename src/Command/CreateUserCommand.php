<?php declare(strict_types=1);

namespace App\Command;


use App\Security\UserRegistration;
use App\Security\UserRegistrationHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    /** @var UserRegistrationHandler */
    private $userRegistrationHandler;

    public function __construct(UserRegistrationHandler $userRegistrationHandler)
    {
        $this->userRegistrationHandler = $userRegistrationHandler;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('chessdb:user:add')
            ->setDescription('Adds a user')
            ->addArgument('username', InputArgument::REQUIRED, 'the username')
            ->addArgument('email', InputArgument::REQUIRED, 'the email address')
            ->addArgument('password', InputArgument::REQUIRED, 'raw password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new UserRegistration();
        $user->setUsername($input->getArgument('username'));
        $user->setEmail($input->getArgument('email'));
        $user->setPassword($input->getArgument('password'));

        $this->userRegistrationHandler->handle($user);

        $output->writeln('User created');
    }
}
