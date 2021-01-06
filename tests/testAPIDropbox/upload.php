<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    /*
    https://www.dropbox.com/developers/apps
    https://www.dropbox.com/home/Aplicaciones
    https://github.com/kunalvarma05/dropbox-php-sdk/wiki/Usage
    */

    require_once 'terceros/dropbox/vendor/autoload.php';

    use Kunnu\Dropbox\Dropbox;
    use Kunnu\Dropbox\DropboxApp;

    $dropboxKey = "2800hhby25a3xsb";
    $dropboxSecret = "ly41vlxqyk16ifw";
    $dropboxToken = "nglSSCsZtpsAAAAAAAAAAT_J8VHf5GKY4Wy3bwBVT3_A868KHfBhdiBiN-Sh6Dwv";
    $app = new DropboxApp($dropboxKey, $dropboxSecret, $dropboxToken);
    $dropbox = new Dropbox($app);
    if (!empty($_FILES)) {
        $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
        $nombre = $filename.'_'.uniqid();
        $tempfile = $_FILES['file']['tmp_name'];
        $ext = explode(".", $_FILES['file']['name']);
        $ext = end($ext);
        $nombre_carpeta="mp3";
        $nombredropbox = "/".$nombre_carpeta."/" . $nombre . "." . $ext;
        //print_r($nombredropbox);
        echo $nombredropbox;
        try {
            $file = $dropbox->simpleUpload($tempfile, $nombredropbox, ['autorename' => true]);
            //http_response_code(200);
            echo '<br>archivo subido<br>';
        } catch (\exception $e) {
            print_r($e);
            //http_response_code(400);
        }

        $response = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
            "path" => $nombredropbox
        ]);
        $data = $response->getDecodedBody();
        var_dump($data);
        echo $data['url'],'<br>';
        $link=substr($data['url'],0,strlen($data['url'])-4);
        $link=$link.'raw=1';
        echo $link;
        echo '<br><br><br><img src="',$link,'"><br><br><br>';
        echo '<audio type="audio/mpeg" src="',$link,'" controls><p>Su navegador no soporta HTML5 (Sí en Opera, Chrome y Firefox)</p></audio><br><br><br>';
    }
    ?>

</body>

</html>