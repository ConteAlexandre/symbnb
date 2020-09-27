<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 2:43 AM
 */

namespace App\Manager;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UsersManager
 * @package App\Manager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UsersManager
{
    protected $em;
    protected $usersRepository;
    protected $logger;
    protected $encoderPassword;

    public function __construct(
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        LoggerInterface $logger,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->em = $entityManager;
        $this->usersRepository = $usersRepository;
        $this->logger = $logger;
        $this->encoderPassword = $passwordEncoder;
    }

    public function createUser()
    {
        $user = new Users();
        return $user;
    }

    public function updatePassword(Users $users)
    {
        if (0 !== strlen($password = $users->getPassword())) {
            $users->setSalt(rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '='));
            $users->setPassword($this->encoderPassword->encodePassword($users, $users->getPassword()));
        }
    }

    public function save(Users $users, $andFlush = true)
    {
        $this->updatePassword($users);

        $this->em->persist($users);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}