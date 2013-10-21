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
					array_push($this->plugins,$entry);
					
					$pluginFile = $entry.".php";
					
	// include file
					if (file_exists($pluginFile)) {
						include($path."/".$pluginFile);
					}
				}
			}
		}
	}


//=====================================================
// return an array of the loaded plugins
	function getPlugins() {
		return $this->plugins;
	}
}
?>