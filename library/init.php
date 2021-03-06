<?PHP


//=====================================================
class System {
	private $param;


//=====================================================
// load system configuration
	function __construct($output) {
// load system configuration
		if (file_exists("config.ini")) {
			$this->param = parse_ini_file("config.ini");
		}
		else {
			$output->error("fatal error: system configuration not found [init.php:__construct]");
		}
	}


//=====================================================
// return parameter
	function get($param) {
		if (key_exists($param,$this->param))
			return ($this->param[$param]);
		else
			return false;
	}
}

?>
