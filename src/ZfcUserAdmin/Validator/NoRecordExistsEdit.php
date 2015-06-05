<?php
/**
 * User: Vladimir Garvardt
 * Date: 3/19/13
 * Time: 11:27 AM
 */

namespace ZfcUserAdmin\Validator;

use ZfcUser\Validator\NoRecordExists;

/**
 * Class NoRecordExistsEdit
 * @package ZfcUserAdmin\Validator
 */
class NoRecordExistsEdit extends NoRecordExists
{
    /**
     * @param $value
     * @param null $context
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $valid = true;
        $this->setValue($value);

        /** @var $result \ZfcUser\Entity\UserInterface|null */
        $result = $this->query($value);
        if ($result && $result->getId() !== $context['userId']) {
            $valid = false;
            $this->error(self::ERROR_RECORD_FOUND);
        }

        return $valid;
    }
}
