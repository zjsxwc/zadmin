<?php
/**
 * Created by IntelliJ IDEA.
 * User: wangchao
 * Date: 3/17/17
 * Time: 9:25 PM
 */

namespace Application\FrontBundle\Service;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;


class SymfonySecurityFirewallUser implements UserInterface, EquatableInterface
{
    private $username;
    private $nickname;
    private $password;
    private $roles;
    private $id;

    public function __construct($username, $password, array $roles, $id, $nickname = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
        $this->id = $id;
        $this->nickname = $nickname;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNickname()
    {
        return $this->nickname;
    }


    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {

        if (!$user instanceof SymfonySecurityFirewallUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }


        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }


}