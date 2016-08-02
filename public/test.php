<?php
define ("AUTH_KEY","AIzaSyD6XNCe-LCK7uLCt80Glv71TcDybRBsA9M");
define ("API_URL","https://www.googleapis.com/urlshortener/v1/url");

function send($long_url=FALSE, $short_url=FALSE) {
    $ku = curl_init();

    curl_setopt($ku,CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($ku,CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($ku,CURLOPT_RETURNTRANSFER,TRUE);

    if($long_url) {
        curl_setopt($ku,CURLOPT_POST,TRUE);
        curl_setopt($ku,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$long_url)));
        curl_setopt($ku,CURLOPT_HTTPHEADER,array("Content-Type:application/json"));
        curl_setopt($ku,CURLOPT_URL,API_URL."?key=".AUTH_KEY);
    }
    elseif($short_url) {
        curl_setopt($ku,CURLOPT_URL,API_URL."?key=".AUTH_KEY."&shortUrl=".$short_url."&projection=ANALYTICS_CLICKS");
    }


    $result = curl_exec($ku);
    curl_close($ku);
    return json_decode($result);
}

for ($i =0; $i<10; $i++) {
    $res = send("https://emailmatrix.ru/emailslab/article-tracking-email-with-google-analytics/?tag=" . $i);
    echo "<pre>";
    print_r($res);
    echo "</pre>";
    $res2 = send(FALSE,$res->id);

?>

    <p style="border:1px solid green;padding:5px">
        Короткая ссылка: <?php echo $res->id;?>
    </p>

    <p style="border:1px solid green;padding:5px">
        Данные по короткой ссылке: <?php echo $res2->id;?><br />
        —— Полная ссылка: <?php echo $res2->longUrl;?><br />
        —— Статус: <?php echo $res2->id;?><br />
        —— Клики: <?php echo $res2->analytics->allTime->shortUrlClicks;?><br />
    </p>

<?php } ?>




