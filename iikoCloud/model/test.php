<?php

require_once 'iikoCloud.php';

use iikoCloud\iikoCloud;

$iiko = new iikoCloud('XXX');

$orgs = $iiko->getOrganizations();
$organizationID = $orgs[0]['id'];


$menu = $iiko->getMenu($organizationID);
$products = $menu['products'];

foreach ($products as $product){
    var_dump($product['name']." == ".$product["sizePrices"][0]["price"]["currentPrice"]);
}

exit;