<?PHP

include ("library/xml.php");
include ("library/init.php");
include ("library/plugin.php");

$output = new Xml();
$system = new System($output);
$plugins = new Plugin("plugin");

$output->render();
?>
