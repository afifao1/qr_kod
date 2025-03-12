<?php 
declare(strict_types=1);

namespace Controllers;

use GuzzleHttp\Client;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Bot{
    public  string $text;
    public  int    $chatId;
    public  string $firstName;

    private string $api;
    private        $http;

    public function __construct(string $token){
        $this->api  = "https://api.telegram.org/bot$token/";
        $this->http = new Client(['base_uri' => $this->api]);
    }

    public function handle(string $update){
        $update = json_decode($update);

        $this->text      = $update->message->text;
        $this->chatId    = $update->message->chat->id;
        $this->firstName = $update->message->chat->first_name;

        if(strpos($this->text, '/') === 0){
            $string     = explode(' ',$this->text,2);
            $this->text = $string[1] ?? $string[0];
            $command    = $string[0];
        }

        match ($command) {
            '/start'    => $this->handleStartCommand() ,
            '/generate' => $this->handleGenerateCommand(),
        };
    }

    public function handleStartCommand(){
        $text  = "Assalomu aleykum $this->firstName";
        $text .= "\n\nBotimizga xush kelibsiz!";
        $text .= "\n\nBotdan foydalanish uchun quyidagi buyruqlardan birini tanlang:";
        $text .= "\n\n\generate - QRCode generatsiya qilish";

        $this->http->post('sendMessage',[
            'form_params' => [
                'chat_id' => $this->chatId,
                'text'    => $text
            ]
            ]);
    }

    public function handleGenerateCommand(){
        $options = (new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG
        ]));

        $qr = (new QRCode($options)) ->render($this->text, 'qr.png');

        $this->http->post('sendPhoto',[
            'multipart' => [
                [
                    'name'     => 'chat_id',
                    'contents' => $this-> chatId
                ],
                [
                    'name'     => 'photo',
                    'contents' => fopen('qr.png', 'r'),
                ]
            ]
                ]);
    }

    public function setWebhook (string $url){
        try{
            $response = $this->http->post('setWebhook',[
                'form_params'              => [
                    'url'                  => $url,
                    'drop_pending_updates' => true
                ]
                ]);

            $response = json_decode($response->getBody()->getContents());

            return $response->description;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }
}