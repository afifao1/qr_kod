<?php 
declare(strict_types=1);

namespace Controllers;

use GuzzleHttp\Client;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Bot{
    public  ?string $text;
    public  int    $chatId;
    public         $img;
    public  string $firstName;
    public         $token;

    private string $api;
    private        $http;

    public function __construct(string $token){
        $this->api   = "https://api.telegram.org/bot$token/";
        $this->http  = new Client(['base_uri' => $this->api]);
        $this->token = $token;
    }
    
    public function handle(string $update){
        $update = json_decode($update);
        
        if (isset($update->message->text)){
            $this->text      = $update->message->text;
            $this->chatId    = $update->message->chat->id;
            $this->firstName = $update->message->chat->first_name;
            $this->handleTextCommand();
        }
        else{
            $this->photo      = $update->message->photo;
            $this->chatId    = $update->message->chat->id;
            $this->firstName = $update->message->chat->first_name;
            $this->handlePhotoCommand($update);
        }

        // if (isset($update->message->photo)){
        //     $this->img = end($update->message->photo)->file_id;
        // }

        // if($this->text) {
        //     if(strpos($this->text, '/') === 0){
        //         $string     = explode(' ',$this->text,2);
        //         $this->text = $string[1] ?? $string[0];
        //         $command    = $string[0];
        //     }
        // }else {
        //     if (!empty($this->img)){
        //         $this->handleReadCommand($token);
        //     }
        // }
            
        // if($command === '/start'){
        //     $this->handleStartCommand();
        // }
        // elseif ($command === '/generate'){
        //     $this->handleGenerateCommand();
        // } 

    }

    public function handleTextCommand(){
        if(strpos($this->text, '/') === 0){
            $string     = explode(' ', $this->text,2);
            $this->text = $string[1] ?? $string[0];
            $command    = $string[0];
        }

        if($command === '/start'){
            $this->handleStartCommand();
        }
        elseif ($command === '/generate'){
            $this->handleGenerateCommand();
        } 
    }

    public function handlePhotoCommand($update){
            $this->img = end($update->message->photo)->file_id;
            $this->handleReadCommand();
        }
    

    public function handleStartCommand(){
        $text  = "Assalomu aleykum $this->firstName";
        $text .= "\n\nBotimizga xush kelibsiz!";
        $text .= "\n\nBotdan foydalanish uchun quyidagi buyruqlardan birini tanlang:";
        $text .= "\n\n/generate - QRCode generatsiya qilish";
        $text .= "\n\n/read - QRCodeni o`qish";

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

    public function handleReadCommand(){


        $responce = $this->http->post('getFile',[
            'form_params' => [
                'file_id' => $this->img
            ]
            ]);

        $file_path = json_decode($responce->getBody()->getContents())->result->file_path;

        $download = "https://api.telegram.org/file/bot$this->token/$file_path";

        $png = file_get_contents($download);
        file_put_contents('qrcode.png', $png);

        $result=(new QRCode())->readFromFile('qrcode.png');
        $content = $result->data;

        $this->http->post('sendMessage',[
            'form_params' => [
                'chat_id' => $this->chatId,
                'text'    => $content,
                'file_id' => $this->img
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
