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
	function getData($xml,$options) {
		if ($this->dbResource) {
			$queryString = "";
			$retXml = new simpleXmlElement("<data/>");
		
			$table = $options["table"];
			$where = $options["search"];

			$queryString = "SELECT * FROM $table WHERE $where";

			if ($res = mysql_query($queryString,$this->dbResource)) {
//				$tmpXml = new simpleXmlElement("<entry/>");
				$tmpXml = $retXml->addChild("<entry>");

				$xml->hits(mysql_num_rows($res));

				while ($mysqlArray = mysql_fetch_array($res,MYSQL_ASSOC)) {

// insert data
					foreach($mysqlArray as $key => $entry) {
						$tmpXml->addChild($key,$entry);
					}

					simplexml_insert($retXml,$tmpXml,"ALL");
				}

				return $retXml;
			}
		}
	}


// write data to database
	function writeData($xml,$option) {
	}

}

?>
