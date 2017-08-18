<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\Model\CustomerDuplicates;

use CustomerManagementFrameworkBundle\Model\CustomerInterface;

interface PotentialDuplicateItemInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return void
     */
    public function setId($id);

    /**
     * @return CustomerInterface[]
     */
    public function getDuplicateCustomers();

    /**
     * @param CustomerInterface[] $duplicateCustomers
     *
     * @return void
     */
    public function setDuplicateCustomers(array $duplicateCustomers);

    /**
     * @return array
     */
    public function getFieldCombinations();

    /**
     * @param array $fieldCombinations
     *
     * @return void
     */
    public function setFieldCombinations(array $fieldCombinations);

    /**
     * @return bool
     */
    public function getDeclined();

    /**
     * @param bool $declined
     *
     * @return void
     */
    public function setDeclined($declined);

    /**
     * @return int
     */
    public function getModificationDate();

    /**
     * @param int $modificationDate
     *
     * @return void
     */
    public function setModificationDate($modificationDate);

    /**
     * @return int
     */
    public function getCreationDate();

    /**
     * @param int $creationDate
     *
     * @return void
     */
    public function setCreationDate($creationDate);
}
