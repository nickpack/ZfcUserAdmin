<?php

namespace ZfcUserAdmin\Form;

use ZfcUser\Entity\UserInterface;
use ZfcUser\Form\Register;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUserAdmin\Options\UserEditOptionsInterface;
use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Class EditUser
 * @package ZfcUserAdmin\Form
 */
class EditUser extends Register
{
    /**
     * @var \ZfcUserAdmin\Options\UserEditOptionsInterface
     */
    protected $userEditOptions;
    /**
     * @var
     */
    protected $userEntity;
    /**
     * @var
     */
    protected $serviceManager;

    /**
     * @param null $name
     * @param UserEditOptionsInterface $options
     * @param RegistrationOptionsInterface $registerOptions
     * @param $serviceManager
     */
    public function __construct($name = null, UserEditOptionsInterface $options, RegistrationOptionsInterface $registerOptions, $serviceManager)
    {
        $this->setUserEditOptions($options);
        $this->setServiceManager($serviceManager);
        parent::__construct($name, $registerOptions);

        $this->remove('captcha');

        if ($this->userEditOptions->getAllowPasswordChange()) {
            $this->add(array(
                'name' => 'reset_password',
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    'label' => 'Generate random password'
                )
            ));

            $password = $this->get('password');
            $password->setAttribute('required', false);
            $password->setOptions(array('label' => 'Password (only if you need to change it)'));

            $this->remove('passwordVerify');
        } else {
            $this->remove('password')->remove('passwordVerify');
        }

        foreach ($this->getUserEditOptions()->getEditFormElements() as $name => $element) {
            // avoid adding fields twice (e.g. email)
            // if ($this->get($element)) continue;

            $this->add(array(
                'name' => $element,
                'options' => array(
                    'label' => $name,
                ),
                'attributes' => array(
                    'type' => 'text'
                ),
            ));
        }

        $this->get('submit')->setLabel('Save')->setValue('Save');

        $this->add(array(
            'name' => 'userId',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
    }

    /**
     * @param $userEntity
     */
    public function setUser($userEntity)
    {
        $this->userEntity = $userEntity;
        $this->getEventManager()->trigger('userSet', $this, array('user' => $userEntity));
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->userEntity;
    }

    /**
     * @param UserInterface $user
     */
    public function populateFromUser(UserInterface $user)
    {
        foreach ($this->getElements() as $element) {
            /** @var $element \Zend\Form\Element */
            $elementName = $element->getName();
            if (strpos($elementName, 'password') === 0) {
                continue;
            }

            $getter = $this->getAccessorName($elementName, false);
            if (method_exists($user, $getter)) {
                $element->setValue(call_user_func(array($user, $getter)));
            }
        }

        foreach ($this->getUserEditOptions()->getEditFormElements() as $element) {
            $getter = $this->getAccessorName($element, false);
            $this->get($element)->setValue(call_user_func(array($user, $getter)));
        }
        $this->get('userId')->setValue($user->getId());
    }

    /**
     * @param $property
     * @param bool $set
     * @return string
     */
    protected function getAccessorName($property, $set = true)
    {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }

    /**
     * @param UserEditOptionsInterface $userEditOptions
     * @return $this
     */
    public function setUserEditOptions(UserEditOptionsInterface $userEditOptions)
    {
        $this->userEditOptions = $userEditOptions;
        return $this;
    }

    /**
     * @return UserEditOptionsInterface
     */
    public function getUserEditOptions()
    {
        return $this->userEditOptions;
    }

    /**
     * @param $serviceManager
     */
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @return mixed
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
