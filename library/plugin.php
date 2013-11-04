<?PHP

//=====================================================
class Plugin {
	private $plugins = array();
	

//=====================================================
// create plugin object
// if path is given, scan dir
	function __construct($path = "") {
		if ($path) {
			if (file_exists($path)) {
				$this->path = $path;

				$this->load($this->path);
			}
		}
	}
	

//=====================================================
// scan plugin directory at path for plugins
	function load($path) {

	// plugin path exists
		$pluginDir = opendir($path);

		while($entry = readdir($pluginDir)) {

	// dir found and not . or ..
			if (is_dir($path."/".$entry)) {
				if ($entry != "." and $entry != "..") {
					$pluginFile = $entry.".php";
					
	// include file
					if (file_exists($path."/".$entry."/".$pluginFile) and file_exists($path."/".$entry."/define.ini")) {
						include_once($path."/".$entry."/".$pluginFile);

						$className = "plugin_".$entry;

	// load plugin parameters and initialize plugin class
						if (class_exists($className)) {
							$plugin_param = parse_ini_file($path."/".$entry."/define.ini");

			//TODO check for type parameter
							$this->plugins[$plugin_param["type"]] = new $className($plugin_param);
						}
						else
							echo "*** plugin class not found: $className<br>";
					}
					else
						echo "*** plugin or definition file not found: $pluginFile<br>";
				}
			}
		}
	}


//=====================================================
	function call($name,$options) {
		$plugin = $this->plugins[$name];
		$scriptName = $options["command"];
		
		return($plugin->$scriptName($options));
	}


//=====================================================
// return an array of the loaded plugins
	function getPlugins() {
		return $this->plugins;
	}
}
?>
