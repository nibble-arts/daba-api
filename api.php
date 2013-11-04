<?PHP

include ("library/xml.php");
include ("library/init.php");
include ("library/plugin.php");

// create output xml
$output = new Xml();

// load system parameters
$system = new System($output);

// load plugins
$plugin = new Plugin($system->get("plugin_path"));


//===========================================================
// search and insert data
$options = array(
	"command" => "getData",
	"table" => "railway",
	"search" => "title LIKE '%graz%'"
);

$output->data($plugin->call("database",$options));




//===========================================================
// render xml to output
$output->render();
?>
