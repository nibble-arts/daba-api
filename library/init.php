<?PHP


//=====================================================
class System {
	private $param;


//=====================================================
// loade and parse config file
	function __construct($output) {
		if (file_exists("config.ini")) {
			$this->param = parse_ini_file("config.ini");
		}
		else {
			$output->error("*** fatal error: System Datei nicht gefunden");
			$output->render();
			die();
		}
	}
	

//=====================================================
// return parameter
	function get($param) {
		if (key_exists($this->param,$param))
			return ($this->param[$param]);
		else
			return false;
	}
}

?>
