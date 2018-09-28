<?php

namespace Application\FrontBundle\Admin;

use Application\FrontBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends AbstractAdmin
{
    protected $translationDomain = 'ApplicationFrontBundle';

    public function prePersist($user)
    {
        /** @var \Application\FrontBundle\Entity\User $user */
        $rawPassword = $user->getPassword();
        $user->setPassword(password_hash($rawPassword, PASSWORD_BCRYPT));
    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('username')
            ->add('enabled')
            ->add('lastLogin')
            ->add('roles')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('mobileNumber')
            ->add('mobileCountry')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('username')
            ->add('enabled', null, ['editable' => true])
            ->add('lastLogin')
            ->add('roles')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('mobileNumber')
            ->add('mobileCountry')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('roles')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('mobileNumber')
            ->add('mobileCountry')
        ;

        /** @var User $subject */
        $subject = $this->getSubject();
        if ($this->isCurrentRoute('create') || (!$subject->getPassword())) {
            $formMapper->add('password');
        }
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('username')
            ->add('enabled')
            ->add('lastLogin')
            ->add('roles')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('mobileNumber')
            ->add('mobileCountry')
        ;
    }
}
