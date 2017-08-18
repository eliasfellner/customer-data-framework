<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\Model\ActivityStoreEntry;

use Carbon\Carbon;
use CustomerManagementFrameworkBundle\Model\ActivityInterface;
use CustomerManagementFrameworkBundle\Model\CustomerInterface;

interface ActivityStoreEntryInterface
{
    public function setData($data);

    public function save($updateAttributes = false);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     *
     * @return void
     */
    public function setId($id);

    /**
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param CustomerInterface $customer
     *
     * @return void
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * @return Carbon
     */
    public function getActivityDate();

    /**
     * @param int $timestamp
     *
     * @return void
     */
    public function setActivityDate($timestamp);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType($type);

    /**
     * @return ActivityInterface
     */
    public function getRelatedItem();

    /**
     * @param ActivityInterface $item
     *
     * @return void
     */
    public function setRelatedItem(ActivityInterface $item);

    /**
     * @return int
     */
    public function getCreationDate();

    /**
     * @param int $timestamp
     *
     * @return void
     */
    public function setCreationDate($timestamp);

    /**
     * @return int
     */
    public function getModificationDate();

    /**
     * @param int $timestamp
     *
     * @return void
     */
    public function setModificationDate($timestamp);

    /**
     * @return string
     */
    public function getMd5();

    /**
     * @param string $md5
     *
     * @return void
     */
    public function setMd5($md5);

    /**
     * @return string
     */
    public function getImplementationClass();

    /**
     * @param string $implementationClass
     *
     * @return void
     */
    public function setImplementationClass($implementationClass);

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes);

    /**
     * @return array
     */
    public function getData();
}
