<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo "Testing input for ZIP 54701<br>";
        include 'yelp.php';
        $response = query_api("54701");
        foreach ($response as $bar) {
            //var_dump($bar);
            $id = $bar->id;
            $phone = $bar->display_phone;
            $name = $bar->name;
            if($id && $phone && $name) {
            echo "<br><br>";
            echo "Bar $name with yelp_id: $id and phone: $phone";
            echo "<br><br>";
            }
        }
        ?>
    </body>
</html>
