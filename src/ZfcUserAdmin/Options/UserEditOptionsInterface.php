<?php

namespace ZfcUserAdmin\Options;

/**
 * Interface UserEditOptionsInterface
 * @package ZfcUserAdmin\Options
 */
interface UserEditOptionsInterface
{
    /**
     * @return mixed
     */
    public function getEditFormElements();

    /**
     * @param array $elements
     * @return mixed
     */
    public function setEditFormElements(array $elements);

    /**
     * @return mixed
     */
    public function getAllowPasswordChange();

    /**
     * @param $allowPasswordChange
     * @return mixed
     */
    public function setAdminPasswordChange($allowPasswordChange);
}
