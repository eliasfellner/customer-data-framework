<?php
/**
 * Created by PhpStorm.
 * User: mmoser
 * Date: 15.11.2016
 * Time: 16:37
 */

namespace CustomerManagementFrameworkBundle\Command;

use CustomerManagementFrameworkBundle\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class BuildSegmentsCommand extends AbstractCommand
{

    protected function configure()
    {
        $this->setName("cmf:build-segments")
            ->setDescription("Build automatically calculated segments")
            ->addOption(
                "force",
                "f",
                null,
                "force all customers (otherwise only entries from the changes queue will be processed)"
            )
            ->addOption(
                "segmentBuilder",
                "s",
                InputOption::VALUE_OPTIONAL,
                "execute segment builder class only (php class name of segment builder)"
            )
            ->addOption(
                'customer',
                'c',
                InputOption::VALUE_OPTIONAL,
                'Limit execution to provided customer-id'
            )->addOption(
                'active-only',
                'a',
                InputOption::VALUE_NONE,
                'Limit to active only'
            )->addOption(
                'inactive-only',
                'i',
                InputOption::VALUE_NONE,
                'Limit to in-active only'
            )->addOption(
                'p-size',
                null,
                InputOption::VALUE_OPTIONAL,
                'Use custom page-size',
                500
            )->addOption(
                'p-start',
                null,
                InputOption::VALUE_OPTIONAL,
                'Start processing at page',
                1
            )->addOption(
                'p-end',
                null,
                InputOption::VALUE_OPTIONAL,
                'Stop further processing at page'
            )->addOption(
                'p-amount',
                null,
                InputOption::VALUE_OPTIONAL,
                'Stop further processing after pages'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customQueue = null;
        if ($input->getOption('customer')) {
            $customQueue = [trim($input->getOption('customer'))];
        }

        $activeState = null;
        if ((bool)$this->input->getOption('active-only')) {
            $activeState = true;
        } elseif ((bool)$this->input->getOption('inactive-only')) {
            $activeState = false;
        }

        $options = [
            'pageSize' => $this->input->getOption('p-size'),
            'startPage' => $this->input->getOption('p-start'),
            'endPage' => $this->input->getOption('p-end'),
            'pages' => $this->input->getOption('p-amount'),
        ];

        /** @var \CustomerManagementFrameworkBundle\SegmentManager\DefaultSegmentManager $segmentManager */
        $segmentManager = \Pimcore::getContainer()->get('cmf.segment_manager');

        $segmentManager->buildCalculatedSegments(
            !$input->getOption("force"),
            $input->getOption("segmentBuilder"),
            $customQueue,
            $activeState,
            $options,
            // capture ctrl+c + kill signal
            true
        );
    }

}