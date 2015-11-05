<?

/**
 * Interfaccia Singleton
 */
if (!interface_exists('ISingletonConfiguration')) {
    interface ISingletonConfiguration
    {
        public static function getInstance();
        public function __clone();
    }
}

/**
 *  Singleton
 */


if (!class_exists('SingletonConfiguration')) {
    
    /**
     * Simple configuration class based on the singleton design pattern
     * which load configuration values from an ini file in the class path
     */
    
    class SingletonConfiguration implements ISingletonConfiguration
    {
        private $configurationFile = 'config.ini';
        
        private $configurationsValues = array();
        
        private static $instance = null;
        
        public static function getInstance()
        {
            if (is_null(self :: $instance)) {
                self :: $instance = new SingletonConfiguration();
            }
            return self :: $instance;
        }
        
        private function __construct()
        {
        	//$file = dirname('__CONFIG_PATH__').'/'.$this->configurationFile;
            $file = dirname(__FILE__).'/../'.$this->configurationFile;
            $this->configurationsValues = parse_ini_file($file);
        }
        
        public function getValue($configurationKey)
        {
            return $this->configurationsValues[$configurationKey];
        }
        
        public function __clone()
        {
            throw new Exception('Non puoi CLONARE un oggetto singleton');
        }
    }
} 

?>