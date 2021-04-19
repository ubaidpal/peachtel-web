<html><head><title>CRUD Tutorial - Create example</title></head><body>
<?php
// Here we define constants /!\ You need to replace this parameters
define('DEBUG', true);
define('PS_SHOP_PATH', 'http://www.myshop.com');
define('PS_WS_AUTH_KEY', 'JXAPHTFRVRGXXGLVW1H6T5HP2R588G4Q');
require_once('./PSWebServiceLibrary.php');

// Here we use the WebService to get the schema of "customers" resource
try
{
	$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);
	$opt = array('resource' => 'customers');
	if (isset($_GET['Create']))
		$xml = $webService->get(array('url' => PS_SHOP_PATH.'/api/customers?schema=synopsis'));
	else
		$xml = $webService->get($opt);
	$resources = $xml->children()->children();
}
catch (PrestaShopWebserviceException $e)
{
	// Here we are dealing with errors
	echo '<b>Error : '.$e->getMessage().'</b>';
}

if (count($_POST) > 0)
{
// Here we have XML before update, lets update XML
	foreach ($resources as $nodeKey => $node)
	{
		$resources->$nodeKey = $_POST[$nodeKey];
	}
	try
	{
		$opt = array('resource' => 'customers');
		if ($_GET['Create'] == 'Creating')
		{
			$opt['postXml'] = $xml->asXML();
			$xml = $webService->add($opt);
			echo "Successfully added.";
		}
	}
	catch (PrestaShopWebserviceException $ex)
	{
		// Here we are dealing with errors
		echo '<b>Error : '.$e->getMessage().'</b>';
	}
}

// We set the Title
echo '<h1>Customer\'s ';
if (isset($_GET['Create'])) echo 'Creation';
else echo 'List';
echo '</h1>';

// We set a link to go back to list if we are in creation
if (isset($_GET['Create']))
	echo '<a href="?">Return to the list</a>';

if (!isset($_GET['Create']))
	echo '<input type="button" onClick="document.location.href=\'?Create\'" value="Create">';
else
	echo '<form method="POST" action="?Create=Creating">';

echo '<table border="5">';
if (isset($resources))
{

echo '<tr>';
if (count($_GET) == 0)
{
	echo '<th>Id</th></tr>';

	foreach ($resources as $resource)
	{
		echo '<tr><td>'.$resource->attributes().'</td></tr>';
	}
}
else
{
	echo '</tr>';
	foreach ($resources as $key => $resource)
	{
		echo '<tr><th>'.$key;
		if ((bool)$resource['required'] == true)
			echo ' (*)'; // * for required fields
		echo '</th><td>';
		if (isset($_GET['Create']))
			echo '<input type="text" name="'.$key.'" value=""/>';
		echo '</td></tr>';
	}
}

}
echo '</table><br/>';

if (isset($_GET['Create']))
	echo '<input type="submit" value="Create"></form>';


?>
</body></html>
