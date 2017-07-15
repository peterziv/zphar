<?php

/**
 * @file packagePhar.php
 * Package one directionary as one phar file.
 * @author Peter (peter.ziv@hotmail.com)
 * @date Oct 12, 2016
 */

namespace ZKit\console\zphar {
    require_once __DIR__ . '/utility/CmdParser.php';

    define('ZPHAR_VERSION', '1.0.1');

    class PharPackage {

        private $console = null;

        public function __construct()
        {
            $this->console = new \ZKit\console\utility\LogConsole;
            $this->console->setDateShow(false);
        }

        private function package($dir, $packageName, $compress, $default)
        {
            try {
                $phar = new \Phar($packageName);
                $phar->buildFromDirectory($dir);
                $phar->setStub($phar->createDefaultStub($default));
                $phar->compressFiles($compress);
            } catch (\Exception $e) {
                $this->console->error($e->getMessage());
                $this->error(7,$e->getMessage());
            }
            $this->console->info('Packaged ' . $dir . ' as ' . $packageName);
        }

        private function getCompress($org)
        {
            $compress = \Phar::BZ2;
            switch ($org) {
                case 'gz':
                    $compress = \Phar::GZ;
                    break;
                case 'none':
                    $compress = \Phar::NONE;
                    break;
                default:
                    break;
            }
            return $compress;
        }

        /**
         * Running environment check
         */
        private function check()
        {
            if (false === \Phar::canWrite()) {
                $this->error(4);
            }
        }

        private function help()
        {
            $this->console->info("ZPHAR " . ZPHAR_VERSION);
            $this->console->info('Usage: php zphar-' . ZPHAR_VERSION . '.phar [options]');
            $this->console->info("options:");
            $this->console->info("  --dir        The full or relative path to the directory");
            $this->console->info("  --name       It can be full or relative package path( suggest that it ends with .phar)");
            $this->console->info("  --default    The file path handler to be used as the executable stub for this phar archive.");
            $this->console->info("  --compress   [Optional]gz or bz2 or none, default is bz2");
            return -1;
        }

        /**
         * main function to execute the package
         * @param array $argv the array for the input arguments, it is the argv (Array of arguments) passed to script.
         * @return int it will exit with 0 if sucess, orwise it is not 0 exit.
         */
        public function run($argv = array())
        {
            $this->console->info("# ZPHAR " . ZPHAR_VERSION);
            $this->console->info("# Packaging the code as phar");
            $this->console->info("# Author: peter.ziv@hotmail.com ");
            $this->console->info("");

            //Start to execute package as phar
            $this->check();
            $parser = new \ZKit\console\utility\CmdParser();
            $rs = $parser->parse($argv);
            if (0 == $rs) {
                $dir = $this->getParam($parser, 'dir');
                $this->checkDir($dir);
                $packageName = $this->getParam($parser, 'name');
                $defaultIndex = $this->getParam($parser, 'default');
                $compressTmp = $parser->requiredParam('compress');
                $argCompress = isset($compressTmp) ? $compressTmp : '';
                $compress = $this->getCompress($argCompress);

                $this->package($dir, $packageName, $compress, $defaultIndex);
            }

            exit($rs);
        }

        private function getParam($parser, $key)
        {
            $value = $parser->requiredParam($key);
            if (is_null($value)) {
                $this->error(5, '--' . $key);
            }
            return $value;
        }

        private function checkDir(&$dir)
        {
            if (!is_dir($dir)) {
                $dir = getcwd() . DIRECTORY_SEPARATOR . $dir;
                if (!is_dir($dir)) {
                    $this->error(6, $dir);
                }
                $this->console->info("The target directory: ".$dir);
            }
        }

        /**
		 * print message by error code, and exit with this error code.
         * @param int $errCode error code
		 */
        private function error($errCode, $additional = '')
        {
            $errs = array(
               -1 => 'UNKNOWN',
                0 => 'SUCCESS',
                1 => 'Syntax error ocurred : none Input',
                2 => 'Syntax error ocurred at ',
                3 => 'Only Support command line now.',
                4 => "Phar can not write, Set \"phar.readonly = Off\" in php.ini.",
                5 => 'This parameter is required: ',
                6 => 'This target directory is not existing: ',
                7 => 'Error to package as phar: ',
            );
            if(!in_array($errCode, array_keys($errs))){
                $errCode = -1;
            }
            $this->console->error($errs[$errCode] . $additional);

            $this->console->info('');
            $this->help();
            exit($errCode);
        }
    }
}
