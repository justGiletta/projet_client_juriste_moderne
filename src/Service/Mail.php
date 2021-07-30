<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{

    private $apiKey = 'dbb1d5045303e3083c2f22388a9e3447';
    private $apiKeySecret = '94ea7b7d397ad8b34f0a0a9be6a072cf';

    public function send($toEmail, $toName, $subject, $content)
    {
        $mj = new Client($this->apiKey, $this->apiKeySecret, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "justfordev@protonmail.com",
                        'Name' => "Me",
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName,
                        ],
                    ],
                    'TemplateID' => 3042834,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' =>
                        [
                            'content' => $content,
                        ],
                ],
            ],
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }
}
