<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace Website\Auth;

use CustomerManagementFrameworkBundle\Model\CustomerInterface;
use Pimcore\Tool\HybridAuth;

/**
 * Responsible for managing logged in state
 */
class AuthService
{
    /**
     * @return \Zend_Auth
     */
    public function getAuth()
    {
        return \Zend_Auth::getInstance();
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->getAuth()->hasIdentity();
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer()
    {
        $customer = null;
        if ($this->isLoggedIn()) {
            $customer = \Pimcore::getContainer()->get('cmf.customer_provider')
                ->getById($this->getAuth()->getIdentity());

            if (!$customer) {
                throw new \RuntimeException('Failed to load logged in customer from customer provider');
            }
        }

        return $customer;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return $this
     */
    public function login(CustomerInterface $customer)
    {
        // mitigate session fixation attacks
        \Zend_Session::regenerateId();
        $this->getAuth()->getStorage()->write($customer->getId());

        return $this;
    }

    /**
     * @return $this
     */
    public function logout()
    {
        $this->getAuth()->clearIdentity();

        // initialize config and log out all providers
        // HA maintains an own session and we want to clear all previous logins
        HybridAuth::initializeHybridAuth();
        \Hybrid_Auth::logoutAllProviders();

        // mitigate session fixation attacks
        \Zend_Session::regenerateId();

        return $this;
    }
}
