<?PHP


//=====================================================
class Database {
	private $database;


//=====================================================
// load database configuration
	function __construct($output) {
		if (file_exists("daba.xml")) {
			$this->database = simplexml_load_file("daba.xml");
		}
		else {
			$output->error("fatal error: database configuration not found [daba.php:__construct]");
		}
	}
	

//=====================================================
}

?>
