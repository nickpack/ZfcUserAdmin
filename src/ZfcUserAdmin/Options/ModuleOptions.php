<?php

namespace ZfcUserAdmin\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 * @package ZfcUserAdmin\Options
 */
class ModuleOptions extends AbstractOptions implements
    UserListOptionsInterface,
    UserEditOptionsInterface,
    UserCreateOptionsInterface
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     * Array of data to show in the user list
     * Key = Label in the list
     * Value = entity property(expecting a 'getProperty())
     */
    protected $userListElements = array('Id' => 'id', 'Name' => 'display_name', 'Email address' => 'email');

    /**
     * Array of form elements to show when editing a user
     * Key = form label
     * Value = entity property(expecting a 'getProperty()/setProperty()' function)
     */
    protected $editFormElements = array();

    /**
     * Array of form elements to show when creating a user
     * Key = form label
     * Value = entity property(expecting a 'getProperty()/setProperty()' function)
     */
    protected $createFormElements = array();

    /**
     * @var bool
     * true = create password automaticly
     * false = administrator chooses password
     */
    protected $createUserAutoPassword = false;

    /**
     * @var int
     * Length of passwords created automatically
     */
    protected $autoPasswordLength = 8;

    /**
     * @var bool
     * Allow change user password on user edit form.
     */
    protected $allowPasswordChange = true;

    /**
     * @var string
     */
    protected $userMapper = 'ZfcUserAdmin\Mapper\UserDoctrine';

    /**
     * @param $userMapper
     */
    public function setUserMapper($userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     * @return string
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * @param array $listElements
     */
    public function setUserListElements(array $listElements)
    {
        $this->userListElements = $listElements;
    }

    /**
     * @return array
     */
    public function getUserListElements()
    {
        return $this->userListElements;
    }

    /**
     * @return array
     */
    public function getEditFormElements()
    {
        return $this->editFormElements;
    }

    /**
     * @param array $elements
     */
    public function setEditFormElements(array $elements)
    {
        $this->editFormElements = $elements;
    }

    /**
     * @param array $createFormElements
     */
    public function setCreateFormElements(array $createFormElements)
    {
        $this->createFormElements = $createFormElements;
    }

    /**
     * @return array
     */
    public function getCreateFormElements()
    {
        return $this->createFormElements;
    }

    /**
     * @param $createUserAutoPassword
     */
    public function setCreateUserAutoPassword($createUserAutoPassword)
    {
        $this->createUserAutoPassword = $createUserAutoPassword;
    }

    /**
     * @return bool
     */
    public function getCreateUserAutoPassword()
    {
        return $this->createUserAutoPassword;
    }

    /**
     * @return bool
     */
    public function getAllowPasswordChange()
    {
        return $this->allowPasswordChange;
    }

    /**
     * @param $allowPasswordChange
     */
    public function setAdminPasswordChange($allowPasswordChange)
    {
        $this->allowPasswordChange = $allowPasswordChange;
    }

    /**
     * @param $autoPasswordLength
     */
    public function setAutoPasswordLength($autoPasswordLength)
    {
        $this->autoPasswordLength = $autoPasswordLength;
    }

    /**
     * @return int
     */
    public function getAutoPasswordLength()
    {
        return $this->autoPasswordLength;
    }
}
