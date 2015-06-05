<?php

namespace ZfcUserAdmin\Options;

/**
 * Interface UserListOptionsInterface
 * @package ZfcUserAdmin\Options
 */
interface UserListOptionsInterface
{
    /**
     * @return mixed
     */
    public function getUserListElements();

    /**
     * @param array $elements
     * @return mixed
     */
    public function setUserListElements(array $elements);
}
