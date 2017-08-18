<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\Model;

use Carbon\Carbon;
use CustomerManagementFrameworkBundle\Model\ActivityStoreEntry\ActivityStoreEntryInterface;

abstract class AbstractObjectActivity extends \Pimcore\Model\Object\Concrete implements PersistentActivityInterface
{
    public function cmfIsActive()
    {
        return $this->getPublished() && ($this->getCustomer() instanceof CustomerInterface);
    }

    public function cmfGetActivityDate()
    {
        return Carbon::createFromTimestamp($this->getCreationDate());
    }

    public function cmfUpdateOnSave()
    {
        return true;
    }

    /**
     * @return string
     */
    public function cmfGetType()
    {
        return $this->getClassName();
    }

    public function cmfToArray()
    {
        $fieldDefintions = $this->getClass()->getFieldDefinitions();

        $result = [];

        foreach ($fieldDefintions as $fd) {
            $fieldName = $fd->getName();
            $result[$fieldName] = $fd->getForWebserviceExport($this);
        }

        unset($result['customer']);

        $result['o_id'] = $this->getId();
        $result['o_key'] = $this->getKey();
        $result['o_path'] = $this->getRealFullPath();

        return $result;
    }

    public static function cmfGetAttributeDataTypes()
    {
        return false;
    }

    public function cmfUpdateData(array $data)
    {
        throw new \Exception('update of pimcore object activities not allowed');
    }

    public static function cmfCreate(array $data, $fromWebservice = false)
    {
        if (!empty($data['o_id'])) {
            $object = self::getById($data['o_id']);

            if (!$object) {
                throw new \Exception(sprintf('object with o_id %s not found', $data['o_id']));
            }
        } else {
            $object = new static;
        }

        if ($fromWebservice) {
            $object->setValues($data['attributes']);
        } else {
            $object->setValues($data);
        }

        return $object;
    }

    public function cmfWebserviceUpdateAllowed()
    {
        return false;
    }

    public static function cmfGetOverviewData(ActivityStoreEntryInterface $entry)
    {
        return false;
    }

    public static function cmfGetDetailviewData(ActivityStoreEntryInterface $entry)
    {
        $attributes = $entry->getAttributes();

        return \Pimcore::getContainer()->get('cmf.activity_view')->formatAttributes(
            $entry->getImplementationClass(),
            $attributes
        );
    }

    public static function cmfGetDetailviewTemplate(ActivityStoreEntryInterface $entry)
    {
        return false;
    }
}
