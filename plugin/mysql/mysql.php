<?PHP

class plugin_mysql {
	var $db;
	var $dbResource;

// create mysql opject
	function __construct($param) {
		$this->db = $param;
		$this->connect($this->db);
	}
	

// connect to database
	function connect($db) {
// establish connection to db server

    $this->dbResource = @MYSQL_CONNECT($db["server"],$db["user"],$db["password"]);

    if (!$this->dbResource)
    {
    	echo('**error no database connection');
			return FALSE;
		}
		else
		{
// connection established
// select database and set prefix
		  @MYSQL_SELECT_DB($db["database"]);

			return $this->dbResource;
		}
	}
	

// get data from database
	function getData($options) {
		$queryString = "";
		$xml = new simpleXmlElement("<entry/>");
		
		$table = $options["table"];
		$where = $options["search"];

		$queryString = "SELECT * FROM $table WHERE $where";

		if ($res = mysql_query($queryString,$this->dbResource)) {
			$mysqlArray = mysql_fetch_array($res,MYSQL_ASSOC);
			
//TODO convert to xml data
			foreach($mysqlArray as $key => $entry) {
				$xml->addChild($key,$entry);
			}
			
			return $xml;
		}
	}


// write data to database
	function writeData($option) {
	}

}

?>
