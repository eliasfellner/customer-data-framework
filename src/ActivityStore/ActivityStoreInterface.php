<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\ActivityStore;

use CustomerManagementFrameworkBundle\Filter\ExportActivitiesFilterParams;
use CustomerManagementFrameworkBundle\Model\ActivityInterface;
use CustomerManagementFrameworkBundle\Model\ActivityList\ActivityListInterface;
use CustomerManagementFrameworkBundle\Model\ActivityStoreEntry\ActivityStoreEntryInterface;
use CustomerManagementFrameworkBundle\Model\CustomerInterface;
use Zend\Paginator\Paginator;

/**
 * Interface ActivityStoreInterface
 *
 * @package CustomerManagementFramework\ActivityStore
 */
interface ActivityStoreInterface
{
    /**
     * @param ActivityInterface $activity
     *
     * @return ActivityStoreEntryInterface
     */
    public function insertActivityIntoStore(ActivityInterface $activity);

    /**
     * @param ActivityInterface $activity
     * @param ActivityStoreEntryInterface $entry
     *
     * @return ActivityStoreEntryInterface
     */
    public function updateActivityInStore(ActivityInterface $activity, ActivityStoreEntryInterface $entry = null);

    /**
     *
     * @param ActivityStoreEntryInterface $entry
     *
     * @return void
     */
    public function updateActivityStoreEntry(ActivityStoreEntryInterface $entry, $updateAttributes = false);

    /**
     * @param ActivityInterface $activity
     *
     * @return ActivityStoreEntryInterface
     */
    public function getEntryForActivity(ActivityInterface $activity);

    /**
     * @param CustomerInterface $customer
     *
     * @return array
     */
    public function getActivityDataForCustomer(CustomerInterface $customer);

    /**
     * @return ActivityListInterface
     */
    public function getActivityList();

    /**
     * @param ActivityInterface $activity
     *
     * @return bool
     */
    public function deleteActivity(ActivityInterface $activity);

    /**
     * @param $id
     *
     * @return ActivityStoreEntryInterface
     */
    public function getEntryById($id);

    /**
     * @param ActivityStoreEntryInterface $entry
     *
     * @return void
     */
    public function deleteEntry(ActivityStoreEntryInterface $entry);

    /**
     * Deletes all activities for $customer in the store.
     *
     * @param CustomerInterface $customer
     *
     * @return void
     */
    public function deleteCustomer(CustomerInterface $customer);

    /**
     * @param                              $pageSize
     * @param int $page
     * @param ExportActivitiesFilterParams $params
     *
     * @return Paginator
     */
    public function getActivitiesDataForWebservice($pageSize, $page = 1, ExportActivitiesFilterParams $params);

    /**
     * @param $type
     * @param $deletionsSinceTimestamp
     *
     * @return mixed
     */
    public function getDeletionsData($type, $deletionsSinceTimestamp);

    /**
     * @param CustomerInterface $customer
     * @param null $activityType
     *
     * @return mixed
     */
    public function countActivitiesOfCustomer(CustomerInterface $customer, $activityType = null);

    /**
     *
     * @param string $operator (>,< or =)
     * @param string $type
     * @param int $count
     *
     * @return array
     */
    public function getCustomerIdsMatchingActivitiesCount($operator, $type, $count);

    /**
     * @return array
     */
    public function getAvailableActivityTypes();

    /**
     * @param array $data
     *
     * @return ActivityStoreEntryInterface
     */
    public function createEntryInstance(array $data);
}
