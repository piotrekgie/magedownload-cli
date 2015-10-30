<?php
/**
 * Magedownload CLI
 *
 * PHP version 5
 *
 * @category  MageDownload
 * @package   MageDownload
 * @author    Steve Robbins <steve@steverobbins.com>
 * @copyright 2015 Steve Robbins
 * @license   http://creativecommons.org/licenses/by/4.0/ CC BY 4.0
 * @link      https://github.com/steverobbins/magedownload-cli
 */

namespace MageDownload\Command;

use MageDownload\Download;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Download command
 *
 * @category  MageDownload
 * @package   MageDownload
 * @author    Steve Robbins <steve@steverobbins.com>
 * @copyright 2015 Steve Robbins
 * @license   http://creativecommons.org/licenses/by/4.0/ CC BY 4.0
 * @link      https://github.com/steverobbins/magedownload-cli
 */
class DownloadCommand extends AbstractCommand
{
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('download')
            ->setDescription('Download a release or patch')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'The file to download'
            );
        parent::configure();
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $download = new Download;
        $file = $input->getArgument('file');
        $result = $download->get(
            $file,
            $this->getAccountId($input),
            $this->getAccessToken($input)
        );
        $success = file_put_contents(getcwd() . DIRECTORY_SEPARATOR . $file, $result);
        if ($success) {
            $output->writeln(sprintf('File saved to <info>%s</info>', $file));
        } else {
            $output->writeln('<error>Failed to download file</error>');
        }
    }
}