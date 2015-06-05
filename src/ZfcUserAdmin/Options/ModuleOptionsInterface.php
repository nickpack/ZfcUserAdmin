<?php

namespace ZfcUserAdmin\Options;

/**
 * Interface ModuleOptionsInterface
 * @package ZfcUserAdmin\Options
 */
interface ModuleOptionsInterface
{
    /**
     * @return mixed
     */
    public function getUserMapper();

    /**
     * @param $mapper
     * @return mixed
     */
    public function setUserMapper($mapper);
}
