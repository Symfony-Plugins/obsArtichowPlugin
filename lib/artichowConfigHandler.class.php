<?php

class artichowConfigHandler extends sfYamlConfigHandler
{
	private $prefix = '';
	
	public function execute($configFiles)
	{
		// Parse the yaml
		$config = $this->parseYamls($configFiles);

		$here = realpath(dirname(dirname(__FILE__)));
		
		$data  = "<?php\n";
		$data .= "define('ARTICHOW', '$here');\n";
        $data .= "define('ARTICHOW_FONT', ARTICHOW.DIRECTORY_SEPARATOR.'".$config['artichow']['fonts']['directory']."');\n";
        $data .= "define('ARTICHOW_PATTERN', ARTICHOW.DIRECTORY_SEPARATOR.'".$config['artichow']['patterns']."');\n";
        $data .= "define('ARTICHOW_IMAGE', ARTICHOW.DIRECTORY_SEPARATOR.'".$config['artichow']['images']."');\n";
        $data .= "define('ARTICHOW_CACHE', ".($config['artichow']['cache']['enabled'] ? 'true' : 'false').");\n";
        $data .= "define('ARTICHOW_CACHE_DIRECTORY', ARTICHOW.DIRECTORY_SEPARATOR.'".$config['artichow']['cache']['directory']."');\n";
        $data .= "define('ARTICHOW_PREFIX', '".$config['artichow']['prefix']."');\n";
        $data .= "define('ARTICHOW_DEPRECATED', ".($config['artichow']['deprecated_error'] ? 'true' : 'false').");\n";
        $data .= "define('ARTICHOW_DRIVER', '".$config['artichow']['driver']."');\n";

        if(isset($config['artichow']['prefix']))
        {
        	$this->prefix = $config['artichow']['prefix'];
        }
        
        $data .= "/* Fonts */\n";
        foreach($config['artichow']['fonts']['list'] as $font)
        {
        	$data .= "class $font extends awFileFont { ";
            $data .= "public function __construct(\$size) { parent::__construct('$font', \$size); }";
            $data .= "}\n";

            /*
            if($this->prefix !== 'aw')
            {
                $data .= "class ".$this->prefix.$font." extends aw$font { }\n";
            }
            */
        }
        for($i = 1; $i <= 5; $i++)
        {
            $data .= "class awFont$i extends awPHPFont { ";
            $data .= "  public function __construct() { parent::__construct($i); } ";
            $data .= "}\n";

            /*
            if($this->prefix !== 'aw')
            {
                $data .= "class ".$this->prefix."Font$i extends awFont$i { }\n";
            }
            */
        }

        $data .= "/* Colors */\n";
        foreach($config['artichow']['colors'] as $name=>$color)
        {
            list($red, $green, $blue) = $color;
            $data .= "class $name extends awColor { ";
            $data .= "public function __construct(\$alpha = 0) { parent::__construct($red, $green, $blue, \$alpha); } ";
            $data .= "}\n";
   
            /*
            if($this->prefix !== 'aw')
            {
                $data .= "class ".$this->prefix.$name." extends aw$name { }\n";
            }
            */
        }
		$data .= "class Transparent extends awColor { public function __construct() { parent::__construct(0,0,0,100); } }\n";
        
        $file = sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'colors.yml';
        $data .= $this->loadColors($file);
                        
        return $data;
	}
	
	public function loadColors($file)
	{
		$configFile = $file;

		$data = "\$colors = array();\n";
		
		if (!is_readable($configFile))
		{
			// can't read the configuration
			$error = sprintf('Configuration file "%s" does not exist or is not readable', $configFile);
			throw new sfConfigurationException($error);
		}
		$config = sfYaml::load($configFile);
		if ($config === false || $config === null)
		{
			// configuration couldn't be parsed
			$error = sprintf('Configuration file "%s" could not be parsed', $configFile);
			throw new sfParseException($error);
		}

		$colors = array();

		$tints = array("100","80","60","40","90","70","50");
		foreach($tints as $tint)
		{
			foreach($config['colors'] as $id=>$color)
			{
				$c = $color[$tint];
				$data .= "\$colors[] = new awColor($c[0], $c[1], $c[2]);\n";
			}
		}

		$data .= "sfConfig::set('colors', \$colors);\n";
		
		return $data;
	}
}

