<?php

if (!function_exists("view")) {
    function view($nombreVista, $params) {
        foreach ($params as $key => $param) {
            $$key = $param;
        }
        $vista = explode('.', $nombreVista); // [0] => nombreVista
        include_once "./views/{$vista[0]}.php";
    }
}
?>