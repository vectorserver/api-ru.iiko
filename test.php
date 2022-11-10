<?php
require_once 'iikoCloud.php';
$iiko = new \iikoCloud\iikoCloud('928b504e-f04');

$organizations = $iiko->getOrganizations();



$org_id = $organizations[0]['id'];


//$stop_lists = $iiko->getStopLists($org_id);

$menu = $iiko->getMenu($org_id);
var_dump($menu);
