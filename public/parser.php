<?php

class Database {

    function __construct() {

        $this->link = new mysqli('localhost', 'medical', 'NZ8s1FPnEJtKJ4wD', 'medical') ;

        if (!$this->link) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

    }

    function add_category($parent, $href){
        $sql = "INSERT INTO `categories`(`parent`, `href`, `parsed`) VALUES ('".$parent."', '".$href."', 0)";
        mysqli_query($this->link, $sql);
    }

    function get_next_cat(){
        $result = mysqli_query ($this->link, "SELECT * FROM `categories` WHERE parsed = 0 LIMIT 0, 1");
        $cat = mysqli_fetch_assoc($result);
        return $cat['href'];
    }

    function update_cat($addr){
        $sql = "UPDATE `categories` SET `parsed`=1 WHERE `href` = '$addr'";
        mysqli_query($this->link, $sql);
    }

    function get_prod(){
        $result = mysqli_query ($this->link, "SELECT * FROM `products` WHERE 1 LIMIT 0, 1");
        $prod = mysqli_fetch_assoc($result);
        return $prod;
    }
    function get_prods(){
        $result = mysqli_query ($this->link, "SELECT * FROM `products` WHERE 1");
        return $result;
    }

    function update_prod($id, $text){
        $sql = "UPDATE `products` SET `description`='$text' WHERE `id` = $id";
        mysqli_query($this->link, $sql);
    }
}

function clean_notes($text){
//    $text=preg_replace("'style=[^\"]*?\"'si","",$text);
    $text = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text);
    $text = str_replace('<p><span><span>&nbsp;</span></span></p>', '', $text);
    $text = str_replace('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '', $text);
    $text = str_replace('<span>·<span>', '<span class="bull">·<span>', $text);
    $text = str_replace('<p>&nbsp;</p>', '', $text);
    $text = str_replace('<p><span>&nbsp;</span></p>', '', $text);
    return $text;
}

$db = new Database();
//$prod = $db->get_prod();
//print_r(clean_notes($prod['description']));
$result = $db->get_prods();
while ($prod = $result->fetch_assoc()) {
//    print_r(clean_notes($prod['description']));
    $db->update_prod($prod['id'], clean_notes($prod['description']));
}


