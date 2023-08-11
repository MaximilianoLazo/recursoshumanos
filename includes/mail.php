<?php

class Mail{

   public $mailer = array(

     'gmail' => array(
         'isSMTP' => true,
         'SMTPAuth' => true,
         'SMTPSecure' => 'ssl',
         'Host' => 'smtp.gmail.com',
         'Port' => 465,
         'Username' => 'user@gmail.com',
         'Password' => 'password',
         'From' => 'user@gmail.com',
         'FromName' => 'Administrator',
     ),

     'hotmail' => array(
         'isSMTP' => true,
         'SMTPAuth' => true,
         'SMTPSecure' => 'tls',
         'Host' => 'smtp.live.com',
         'Port' => 25,
         'Username' => 'user@hotmail.com',
         'Password' => 'password',
         'From' => 'user@hotmail.com',
         'FromName' => 'Administrator',
     ),
     'ferozo' => array(
         'isSMTP' => true,
         'SMTPAuth' => true,
         'SMTPSecure' => 'ssl',
         'Host' => 'c1840430.ferozo.com',
         'Port' => 465,
         'Username' => 'noresponder@gualeguay.gob.ar',
         'Password' => 'CraM7sWe',
         'From' => 'noresponder@gualeguay.gob.ar',
         'FromName' => 'Municipalidad de Gualeguay',
     ),

   );
}
?>
