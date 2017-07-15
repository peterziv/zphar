<?php
/**
 * ZKit Utility Tool - Command parser
 * @author Peter (peter.ziv@hotmail.com)
 * @date July 15, 2017
 * @version 1.0
 */

namespace ZKit\console\utility {
    require __DIR__ . '/Log.php';

    /**
     * The tool to parser the command input
     */
    class CmdParser
    {

        private $console = null;
        protected $params = array();

        private $errs = array(
            -1 => 'UNKNOWN issue when parsing command.',
            0 => 'SUCCESS',
            1 => 'Syntax error ocurred : none Input.',
            2 => 'Syntax error ocurred at ',
            3 => 'Only Support command line now.',
            4 => 'This parameter is required: ',
        );

        public function __construct()
        {
            $this->console = new LogConsole;
            $this->console->setDateShow(false);
        }

        /**
         * Running environment check
         */
        private function check()
        {
            if ('cli' !== PHP_SAPI) {
                $this->console->error($this->errs[3]);
                return false;
            }
            return true;
        }

        /**
         * parse the command input for parameters.
         * @param array $argv the array for the input arguments, it is the argv (Array of arguments) passed to script.
         * @return int it will exit with 0 if sucess, orwise it is not 0 exit.
         */
        public function parse($argv = array())
        {
            $rs = -1;
            if ($this->check()) {
                $rs = $this->parseArgs($argv);
            }
            $this->console->debug($this->params);
            return $rs;
        }

        /**
         * find the parmeter in the command input by key
         * @param string $key parameter key
         * @return the parameter value
         */
        public function requiredParam($key)
        {
            if (!array_key_exists($key, $this->params)) {
                return null;
            }
            return $this->params[$key];
        }

        private function findKey($param)
        {
            $key = null;
            $this->console->debug($param);
            if ('--' === substr($param, 0, 2)) {
                $key = substr($param, 2);
            }
            $this->console->debug('key=' . $key);
            return $key;
        }

        /**
         * Parse the parameter for the input command.
         * @param array $argv input command array, which may contain invalid parameters.
         * @return array parameters array
         */
        private function parseArgs($argv = array())
        {
            $v = array_shift($argv);
            if (is_null($v)) {
                $this->console->error($this->errs[1]);
                return 1;
            }
            $key = null;
            $this->params = array();
            while($param = array_shift($argv)){
                if(is_null($key)){
                    $key = $this->findKey($param);
                    continue;
                }
                $this->params[$key] = $param;
                $key = null;
            }
            return 0;
        }
    }
}
