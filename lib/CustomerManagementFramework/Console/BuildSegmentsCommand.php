<?php
/**
 * Created by PhpStorm.
 * User: mmoser
 * Date: 15.11.2016
 * Time: 16:37
 */

namespace CustomerManagementFramework\Console;

use CustomerManagementFramework\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildSegmentsCommand extends AbstractCommand {

    protected function configure()
    {
        $this->setName("cmf:build-segments")
            ->setDescription("Build automatically calculated segments")
            ->addOption("force", "f", null, "force all customers (otherwise only entries from the changes queue will be processed)")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        \Pimcore::getDiContainer()->set("CustomerManagementFramework\\Logger", $this->getLogger());

        Factory::getInstance()->getSegmentManager()->buildCalculatedSegments(!$input->getOption("force"));
    }

}