<?php

namespace ZfcUserAdmin\Mapper;

use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;

/**
 * Class UserDoctrine
 * @package ZfcUserAdmin\Mapper
 */
class UserDoctrine extends ZfcUserDoctrineMapper
{
    /**
     * @return mixed
     */
    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getUserEntityClass());
        return $er->findAll();
    }


    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->getEventManager()->trigger('remove.pre', $this, array('entity' => $entity));
        $this->em->remove($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('remove', $this, array('entity' => $entity));
    }
}
