<?php
/**
 * @file Log.console.php
 * This class is one log debugger.
 * @author Peter (peter.ziv@hotmail.com)
 * 
 * @example 
    $b = new LogConsole();
    $b->error("console", true);
    $b->info("info - console");
    $b->warning("warning - console");
 
    $c = LogConsole::getInstance("ZKit\Console\LogConsole");
    $c->info("singlet - console - info");

 * 
 */
//date_default_timezone_set('PRC');
//define('APP_DEBUG',true);




namespace ZKit\Console {

    class LogConsole extends LogBasic {

        protected function log($type, $log) {
            $info = parent::log($type, $log);
            echo $info . PHP_EOL;
        }
    }

    /**
     * Basic class for the log
     * Notice: This is private class, it is used in code directly
     */
    class LogBasic{
        protected static $_instance = null;
        protected $isDateShow = true;


        public function setDateShow($isDateShow = true){
            $this->isDateShow = $isDateShow;
        }

        public static function getInstance($calledClass = '') {
            if (!isset(self::$_instance)) {
                self::$_instance = new $calledClass;
            }

            return self::$_instance;
        }

        protected function log($type, $log) {
            $info = "";
            if ($this->isDateShow){
                $info = date('Y-m-d h:i:s');
            }
            $info.=$type . $log;
            return $info;
        }

        public function info($log, $flag = '') {
            $this->log($flag, $log);
        }

        public function debug($log) {
            if (defined('APP_DEBUG')) {
                $this->log("[DEBUG] ", $log);
            }
        }

        public function error($log) {
            $this->log("[ERROR] ", $log);
        }

        public function warning($log) {
            $this->log("[WARNING] ", $log);
        }
    }

}