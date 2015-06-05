<?php

namespace ZfcUserAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcUser\Mapper\UserInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;
use ZfcUserAdmin\Options\ModuleOptions;

/**
 * Class UserAdminController
 * @package ZfcUserAdmin\Controller
 */
class UserAdminController extends AbstractActionController
{
    /**
     * @var
     */
    protected $options;
    /**
     * @var
     */
    protected $userMapper;
    /**
     * @var
     */
    protected $zfcUserOptions;
    /**
     * @var \ZfcUserAdmin\Service\User
     */
    protected $adminUserService;

    /**
     * @return array
     */
    public function listAction()
    {
        $userMapper = $this->getUserMapper();
        $users = $userMapper->findAll();
        if (is_array($users)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($users));
        } else {
            $paginator = $users;
        }

        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));
        return array(
            'users' => $paginator,
            'userlistElements' => $this->getOptions()->getUserListElements()
        );
    }

    /**
     * @return array
     */
    public function createAction()
    {
        /** @var $form \ZfcUserAdmin\Form\CreateUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_createuser_form');
        $request = $this->getRequest();

        /** @var $request \Zend\Http\Request */
        if ($request->isPost()) {
            $zfcUserOptions = $this->getZfcUserOptions();
            $class = $zfcUserOptions->getUserEntityClass();
            $user = new $class();
            $form->setHydrator(new ClassMethods());
            $form->bind($user);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user = $this->getAdminUserService()->create($form, (array)$request->getPost());
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was created');
                    return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
                }
            }
        }

        return array(
            'createUserForm' => $form
        );
    }

    /**
     * @return array
     */
    public function editAction()
    {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->getUserMapper()->findById($userId);

        /** @var $form \ZfcUserAdmin\Form\EditUser */
        $form = $this->getServiceLocator()->get('zfcuseradmin_edituser_form');
        $form->setUser($user);

        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $this->getAdminUserService()->edit($form, (array)$request->getPost(), $user);
                if ($user) {
                    $this->flashMessenger()->addSuccessMessage('The user was edited');
                    return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
                }
            }
        } else {
            $form->populateFromUser($user);
        }

        return array(
            'editUserForm' => $form,
            'userId' => $userId
        );
    }

    /**
     * @return mixed
     */
    public function removeAction()
    {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');

        /** @var $identity \ZfcUser\Entity\UserInterface */
        $identity = $this->zfcUserAuthentication()->getIdentity();
        if ($identity && $identity->getId() == $userId) {
            $this->flashMessenger()->addErrorMessage('You can not delete yourself');
        } else {
            $user = $this->getUserMapper()->findById($userId);
            if ($user) {
                $this->getUserMapper()->remove($user);
                $this->flashMessenger()->addSuccessMessage('The user was deleted');
            }
        }

        return $this->redirect()->toRoute('zfcadmin/zfcuseradmin/list');
    }

    /**
     * @param ModuleOptions $options
     * @return $this
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return ModuleOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('zfcuseradmin_module_options'));
        }
        return $this->options;
    }

    /**
     * @return mixed
     */
    public function getUserMapper()
    {
        if (null === $this->userMapper) {
            $this->userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }
        return $this->userMapper;
    }

    /**
     * @param UserInterface $userMapper
     * @return $this
     */
    public function setUserMapper(UserInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        return $this;
    }

    /**
     * @return \ZfcUserAdmin\Service\User
     */
    public function getAdminUserService()
    {
        if (null === $this->adminUserService) {
            $this->adminUserService = $this->getServiceLocator()->get('zfcuseradmin_user_service');
        }
        return $this->adminUserService;
    }

    /**
     * @param $service
     * @return $this
     */
    public function setAdminUserService($service)
    {
        $this->adminUserService = $service;
        return $this;
    }

    /**
     * @param ZfcUserModuleOptions $options
     * @return $this
     */
    public function setZfcUserOptions(ZfcUserModuleOptions $options)
    {
        $this->zfcUserOptions = $options;
        return $this;
    }

    /**
     * @return \ZfcUser\Options\ModuleOptions
     */
    public function getZfcUserOptions()
    {
        if (!$this->zfcUserOptions instanceof ZfcUserModuleOptions) {
            $this->setZfcUserOptions($this->getServiceLocator()->get('zfcuser_module_options'));
        }
        return $this->zfcUserOptions;
    }
}
