<?php
/**
 * Created by PhpStorm
 * User: shadowluffy
 * Date: 9/27/20
 * Time: 2:43 AM
 */

namespace App\Manager;

use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

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

    public function __construct(
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        LoggerInterface $logger
    )
    {
        $this->em = $entityManager;
        $this->usersRepository = $usersRepository;
        $this->logger = $logger;
    }
}