<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $Api_Key = 'b32b621e1eb0e11d94b23db60f520d36';
    private $Api_Key_Secret = '401a029e91c19b1097505c6e0b1febed';


    public function send($to_mail, $subject, $Content, $Content_Footer)
    {
        $mj  = new Client($this->Api_Key, $this->Api_Key_Secret, true,['version' => 'v3.1']);
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "password_reset@meilleureseriefrancaise.fr",
                'Name' => "MeilleureSerieFrancaise.fr"
            ],
            'To' => [
                [
                    'Email' => $to_mail,
                    'Name' => "passenger 1"
                ]
            ],
            'TemplateID' => 2041450,
            'TemplateLanguage' => true,
            'Subject' => "Redéfinition de votre mot de passe",
            'Variables' => [
    "Content"=> $Content,
    "Footer"=> $Content_Footer
  ]
        ]
    ]
];

        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}

