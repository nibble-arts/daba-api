<?PHP

class Input {
//=====================================================
	private $database = "";
	private $search = "";
	private $start = 1;
	private $limit = 0;


	function __construct($xml,$param) {
		if (key_exists("database",$param)) $this->database = $param["database"];
		if (key_exists("search",$param)) $this->search = $param["search"];
		if (key_exists("start",$param)) $this->start = $param["start"];
		if (key_exists("limit",$param)) $this->limit = $param["limit"];

		if ($this->search) {
			$searchArray = explode("=",$this->search);
			
			$this->search = $searchArray[0]." LIKE '%".$searchArray[1]."%'";
			$xml->search($this->search);
		}
		
	}


	function search() {
		return $this->search;
	}
}

?>
