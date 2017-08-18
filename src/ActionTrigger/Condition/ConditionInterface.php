<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\ActionTrigger\Condition;

use CustomerManagementFrameworkBundle\Model\CustomerInterface;
use Psr\Log\LoggerInterface;

interface ConditionInterface
{
    /**
     * ConditionInterface constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger);

    /**
     * @param ConditionDefinitionInterface $conditionDefinition
     * @param CustomerInterface $customer
     *
     * @return bool
     */
    public function check(ConditionDefinitionInterface $conditionDefinition, CustomerInterface $customer);

    /**
     * @param ConditionDefinitionInterface $conditionDefinition
     *
     * @return string
     */
    public function getDbCondition(ConditionDefinitionInterface $conditionDefinition);

    /**
     * @param $setting
     *
     * @return ConditionDefinitionInterface
     */
    public static function createConditionDefinitionFromEditmode($setting);

    /**
     * @param ConditionDefinitionInterface $conditionDefinition
     *
     * @return array
     */
    public static function getDataForEditmode(ConditionDefinitionInterface $conditionDefinition);
}
