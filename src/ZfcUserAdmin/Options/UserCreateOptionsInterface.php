<?php

namespace ZfcUserAdmin\Options;

/**
 * Interface UserCreateOptionsInterface
 * @package ZfcUserAdmin\Options
 */
interface UserCreateOptionsInterface
{
    /**
     * @return mixed
     */
    public function getCreateUserAutoPassword();

    /**
     * @param $createUserAutoPassword
     * @return mixed
     */
    public function setCreateUserAutoPassword($createUserAutoPassword);

    /**
     * @return mixed
     */
    public function getCreateFormElements();

    /**
     * @param array $elements
     * @return mixed
     */
    public function setCreateFormElements(array $elements);
}
