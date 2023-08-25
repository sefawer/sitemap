<?php
if(isset($_REQUEST['get_site_map'])){
    echo $_SERVER["SERVER_NAME"]."<br />";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_SERVER["SERVER_NAME"]);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpCode!=200){
        echo "Failed";
    }
    else{
        $parsedBody=explode("<a ",$resp);
        array_shift($parsedBody);
        $ancList=array();
        foreach($parsedBody as $anc){
            $parsedanc=explode('href="', $anc);
            array_shift($parsedanc);
            if (strpos($parsedanc[0],$_SERVER["SERVER_NAME"])===0){
                $parsedSitemapLink=explode('"', $parsedanc[0]);
                $link=$parsedSitemapLink[0];
                $remainingPart=explode(">",$parsedanc[0]);
                $partToGetTitle=explode("</a",$remainingPart[1]);
                $ancList[$link]=$partToGetTitle[0];
            }
        }
        var_dump($ancList);
        exit();
        $pdo = new PDO("mysql:host=localhost;dbname=supermomo", 'root', '');
        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        $unbufferedResult = $pdo->query("SELECT * FROM links");
        foreach ($unbufferedResult as $row) {
            echo '<a href="'.$row['url_key'].'">'.$row['title'].'</a><br />';
        }
    }
}
?>
<form>
    <input type="submit" value="create site map" name="get_site_map" />
</form> 