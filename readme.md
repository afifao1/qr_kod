1) This project generates and reads QRCode. It has a Bot and Web part, both of which can be run within the same qrcode interface.
2) To install QRcode, you first need to go to github and git clone or git pull it, and then install the necessary libraries. "Vendor/autoload, chillerlan, guzzlehttp".
3) To run QRCode, you need to run the server,
"localhost:8888",
start ngrok http,
"ngrok http 8888",
start webhook,
"php webhook.php (and the url address given by ngrok) ".