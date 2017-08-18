<?php

/**
 * Pimcore Customer Management Framework Bundle
 * Full copyright and license information is available in
 * License.md which is distributed with this source code.
 *
 * @copyright  Copyright (C) Elements.at New Media Solutions GmbH
 * @license    GPLv3
 */

namespace CustomerManagementFrameworkBundle;

class Factory
{
    private function __construct()
    {
    }

    /**
     * @return static
     */
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param            $className
     * @param null $needsToBeSubclassOf
     * @param array|null $constructorParams
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function createObject($className, $needsToBeSubclassOf = null, array $constructorParams = [])
    {
        if (!class_exists($className)) {
            throw new \Exception(sprintf('class %s does not exist', $className));
        }

        $object = new $className(...array_values($constructorParams));

        if (!is_null($needsToBeSubclassOf) && !is_subclass_of($object, $needsToBeSubclassOf)) {
            throw new \Exception(sprintf('%s needs to extend/implement %s', $className, $needsToBeSubclassOf));
        }

        return $object;
    }
}
