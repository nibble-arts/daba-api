<?PHP

class plugin_mysql {
	var $db;
	var $dbResource;

// create mysql opject
	function __construct($xml,$param) {
		$this->db = $param;
		$this->connect($xml,$this->db);
	}
	

// connect to database
	function connect($xml,$db) {
// establish connection to db server

    $this->dbResource = @MYSQL_CONNECT($db["server"],$db["user"],$db["password"]);

    if (!$this->dbResource)
    {
    	$xml->error("can't establish database connection [plugin_mysql:connect]");
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
		if ($this->dbResource) {
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
	}


// write data to database
	function writeData($option) {
	}

}

?>
