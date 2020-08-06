<?php

namespace App\Services;

class MessageService
{
    /**
     * @param string $name
     * @param string $message
     * @param string $email
     * @return array
     */
    public static function sendToTelegram(string $name, string $message, string $email)
    {
        $token = "1250518497:AAHVcQSwG66YbbR_NMkcDuDATpQNvIh2DSs";
        $chat_id = "-1001180705660";
        $arr = [
            'Имя пользователя: ' => $name,
            'Сообщение: ' => $message,
            'E-mail: ' => $email
        ];

        $txt = null;
        foreach($arr as $key => $value) {
            $txt .= "<b>".$key."</b> ".$value."%0A";
        };

        $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

        if (!$sendToTelegram ) {
            return [
                'isError' => true,
                'message' => 'Message was not sent',
            ];
        } else {
            fclose($sendToTelegram);
            return [
                'isError' => false,
                'message' => 'Message has been successfully sanded',
            ];
        }
    }
}


