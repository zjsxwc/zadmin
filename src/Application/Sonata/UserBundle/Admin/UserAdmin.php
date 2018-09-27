<?php

declare(strict_types=1);

namespace Application\Sonata\UserBundle\Admin;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserAdmin extends BaseUserAdmin
{
    public function checkAccess($action, $object = null)
    {
        /** @var \Application\Sonata\UserBundle\Entity\User $object */
        if ($action === 'show') {
            $session = $this->getRequest()->getSession();

            $serializeStr = $session->get('_security_staff');
            /** @var UsernamePasswordToken $securityToken */
            $securityToken = null;
            if ($serializeStr) {
                try {
                    $securityToken = unserialize($serializeStr);
                } catch (\Throwable $exception) {
                    //do some logs
                }
            }
            if ($securityToken) {
                /** @var \Application\Sonata\UserBundle\Entity\User $currentUser */
                $currentUser = $securityToken->getUser();
                if ($currentUser && ($currentUser->getId() === $object->getId())) {
                    //如果要查看用户自己的用户数据那么直接允许
                    return true;
                }
            }
        }

        return parent::checkAccess($action, $object);
    }
}
