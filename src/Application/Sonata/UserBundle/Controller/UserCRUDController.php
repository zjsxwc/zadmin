<?php



namespace Application\Sonata\UserBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class UserCRUDController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function showAction($id = null)
    {
        /** @var \Application\Sonata\UserBundle\Entity\User $currentUser */
        $currentUser = $this->getUser();
        //add custom code here

        return parent::showAction($id);
    }
}
