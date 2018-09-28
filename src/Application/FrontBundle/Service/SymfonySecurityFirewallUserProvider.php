<?php
/**
 * Created by PhpStorm.
 * User: wangchao
 * Date: 26/09/2018
 * Time: 2:01 PM
 */

namespace Application\FrontBundle\Service;

use Application\FrontBundle\Entity\User;
use Application\FrontBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SymfonySecurityFirewallUserProvider implements UserProviderInterface
{

    /** @var  \Doctrine\Bundle\DoctrineBundle\Registry  */
    private $doctrine;

    /**
     * SymfonySecurityFirewallUserProvider constructor.
     * @param $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param string $username
     * @return UserInterface|SymfonySecurityFirewallUser
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function loadUserByUsername($username)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->doctrine->getRepository('ApplicationFrontBundle:User');
        /** @var User $maybeUser */
        $maybeUser = null;
        if (strpos($username, "_") === false) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }

        list($mobileCountry, $mobileNumber) = explode("_", $username);

        /** @var User $maybeUser */
        $maybeUser = $userRepository->findOneBy([
            "mobileNumber" => $mobileNumber,
            "mobileCountry" => $mobileCountry
        ]);

        if (!$maybeUser){
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }
        if (!$maybeUser->isEnabled()){
            throw new UsernameNotFoundException(
                sprintf('Username "%s" is disabled.', $username)
            );
        }
        return new SymfonySecurityFirewallUser($username, $maybeUser->getPassword(), $maybeUser->getRoles(), $maybeUser->getId(), $maybeUser->getFullname());
    }

    /**
     * @param UserInterface $user
     * @return UserInterface|SymfonySecurityFirewallUser
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof SymfonySecurityFirewallUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        $maybeInvalidPassword = $user->getPassword();

        $freshUser = $this->loadUserByUsername($user->getUsername());
        if ($freshUser->getPassword() != $maybeInvalidPassword){
            throw new UsernameNotFoundException(
                sprintf('User may be overdue.', $user->getUsername())
            );
        }
        return $freshUser;
    }

    public function supportsClass($class)
    {
        return SymfonySecurityFirewallUser::class === $class;
    }
}