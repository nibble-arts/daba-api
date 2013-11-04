<?PHP

//=====================================================
class Xml {
	private $xml;
	
//=====================================================
// create ouput xml
	function __construct() {
	// initialice output xml

		$this->xml = new SimpleXmlElement("
			<api>
				<data/>
				<diagnostic>
					<hits>0</hits>
				</diagnostic>
			</api>
		");
	}


//=====================================================
// insert error message
	function error($error) {
		$this->xml->diagnostic->error = $error;
	}
	
	
//=====================================================
// insert hits count
	function hits($hits) {
		$this->xml->diagnostic->hits = $hits;
	}
	
	
//=====================================================
// insert count
	function entries($entries) {
		$this->xml->diagnostic->entries = $entries;
	}
	
	
//=====================================================
// insert data
	function data($data) {
		simplexml_insert($this->xml->data,$data,"ALL");

		$this->entries(count($this->xml->xPath("//entry")));
	}


//=====================================================
// output xml
	function render() {
		echo "<pre>";
		print_r($this->xml);
		echo "</pre>";
	}
}


//------------------------------------------------------------------------------
// insert complex xml structure to xml object
//
// option = ALL ... insert starting at xml basis
// option = ALL_UNIQUE ... insert starting at xml basis if node does not exist
// option = UNIQUE ... insert if node does not exist

function simplexml_insert(&$xml_to,$xml_from,$option = "")
{
	if ($xml_from)
	{
		$option = strtoupper($option);
		$name = $xml_from->getName();

// parse options
		switch ($option)
		{
// insert starting at xml basis if node does not exists
			case 'ALL_UNIQUE':
				if ($xml_to->$name->getName() == $name)
				break;
				
// insert starting at xml basis
			case 'ALL':
				$option = ""; // clear option for recursion

				$new_child = $xml_to->addChild($name);
				foreach($xml_from->attributes() as $attr_key => $attr_value)
				{
					$new_child->addAttribute($attr_key,$attr_value);
				}
				
				// recursion to new entry
				simplexml_insert($new_child,$xml_from);

				break;

// insert if node does not exist
			case 'UNIQUE':
				if ($xml_to->$name->getName() == $name)
				break;

			default:
//------------------------------------------------------------------------------
// insert complex structure
				if (count($xml_from->children()))
				{
					foreach ($xml_from->children() as $xml_child)
					{
						$xml_temp = $xml_to->addChild($xml_child->getName(), (string) $xml_child);
						foreach ($xml_child->attributes() as $attr_key => $attr_value)
						{
						    $xml_temp->addAttribute($attr_key, $attr_value);
						}

		// add recursive
						if (count($xml_child->children()))
							simplexml_insert($xml_temp, $xml_child);
					}
				}
				else
		// insert single entry
				{
					$xml_temp = $xml_to->addChild($xml_from->getName(), (string) $xml_from);
					foreach ($xml_from->attributes() as $attr_key => $attr_value)
					{
							$xml_temp->addAttribute($attr_key, $attr_value);
					}
				}
				break;
		}
	}
} 
?>
