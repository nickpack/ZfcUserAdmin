<?php

namespace ZfcUserAdmin\Form;

use ZfcUserAdmin\Options\UserCreateOptionsInterface;
use ZfcUser\Options\RegistrationOptionsInterface;
use ZfcUser\Form\Register as Register;

/**
 * Class CreateUser
 * @package ZfcUserAdmin\Form
 */
class CreateUser extends Register
{
    /**
     * @var RegistrationOptionsInterface
     */
    protected $createOptionsOptions;

    /**
     * @var
     */
    protected $serviceManager;
    /**
     * @var UserCreateOptionsInterface
     */
    protected $createOptions;

    /**
     * @param null $name
     * @param UserCreateOptionsInterface $createOptions
     * @param RegistrationOptionsInterface $registerOptions
     * @param $serviceManager
     */
    public function __construct($name = null, UserCreateOptionsInterface $createOptions, RegistrationOptionsInterface $registerOptions, $serviceManager)
    {
        $this->setCreateOptions($createOptions);
        $this->setServiceManager($serviceManager);
        parent::__construct($name, $registerOptions);

        if ($createOptions->getCreateUserAutoPassword()) {
            $this->remove('password');
            $this->remove('passwordVerify');
        }

        foreach ($this->getCreateOptions()->getCreateFormElements() as $name => $element) {
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

        $this->get('submit')->setAttribute('label', 'Create');
    }

    /**
     * @param UserCreateOptionsInterface $createOptionsOptions
     * @return $this
     */
    public function setCreateOptions(UserCreateOptionsInterface $createOptionsOptions)
    {
        $this->createOptions = $createOptionsOptions;
        return $this;
    }

    /**
     * @return UserCreateOptionsInterface
     */
    public function getCreateOptions()
    {
        return $this->createOptions;
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
