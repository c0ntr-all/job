<?php
$token = "534687564:AAHgDHb5HqvVSCJe28nJ-bDwQzdXyOcxixQ";
$chat_id = "531730209";

$values = $hook->getValues();

$formName = $modx->getOption('formName', $formit->config, 'form-'.$modx->resource->get('id'));

$ip = $modx->getOption('REMOTE_ADDR', $_SERVER, '');

$name = $values['name'];
$phone = $values['phone'];
$email = $values['email'];
$message = $values['text'];

$arr = array(
"Имя" => $name,
"Телефон" => $phone,
"E-mail" => $email,
"Сообщение" => $message);

foreach($arr as $key => $value) { 
     $txt .= "<b>".$key."</b>: ".$value."%0A"; 
  }
//$txt = urlencode($txt);
$output=fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

return true;