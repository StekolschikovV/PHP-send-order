<?php

$haystack = $_SERVER['REQUEST_URI'];
$needle   = 'order';

$pos = strripos($haystack, $needle);

if ($pos === false) {
    echo "ERROR";
} else {
//
    $siteName = "SuperSite";
    $payLink = "www.SuperSite.com/pay";
    $adminMail = "mou.mail.com@gmail.com";
//

// json
    $file = file_get_contents('json.txt', true);
    $arr = array();
    if(isset($file)){
        $arr = json_decode($file ,true);
    }
    $arr[count($arr)+1]["name"] = $_GET["name"];
    $arr[count($arr)]["email"] = $_GET["email"];
    $arr[count($arr)]["notes"] = $_GET["notes"];
    $arr[count($arr)]["adress"] = $_GET["adress"];
    $arr[count($arr)]["price"] = $_GET["price"];
    $arr[count($arr)]["quantity"] = $_GET["quantity"];
    $fp = fopen("json.txt", "w");
    fwrite($fp, json_encode($arr));
    fclose ($fp);
// json//

// mess
    $messageClient = "Здравствуйте!\r\n\r\nВы сделали заказ на сайте ".$siteName."!\r\n\r\nСодержимое заказа: ".$_GET["quantity"]."\r\n\r\nСсылка для оплаты: ".$payLink;
    $message = wordwrap($messageClient, 70, "\r\n");
    mail($_GET["email"], 'Заказ', $message);

    $messageAdmin = "Cделан заказ на сайте ".$siteName."!\r\n\r\nСодержимое заказа: ".$_GET["quantity"]."\r\n\r\nДругие данные из запроса: ".$_GET["name"]." / ".$_GET["email"]." / ".$_GET["notes"]." / ".$_GET["adress"]." / ".$_GET["price"]." / ".$_GET["quantity"]."\r\n\r\nID: ".(count($arr)+1);
    $message = wordwrap($messageAdmin, 70, "\r\n");
    mail($adminMail, 'Заказ', $message);
// mess//
}


?>
