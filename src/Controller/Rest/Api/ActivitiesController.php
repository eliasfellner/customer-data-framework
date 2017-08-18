<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle\Controller\Rest\Api;

use CustomerManagementFrameworkBundle\Controller\Rest\CrudHandlerController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activities")
 */
class ActivitiesController extends CrudHandlerController
{
    /**
     * @return \CustomerManagementFrameworkBundle\RESTApi\ActivitiesHandler
     */
    protected function getHandler()
    {
        return \Pimcore::getContainer()->get('cmf.rest.activities_handler');
    }
}
