<?php
$link = mysqli_connect("localhost","root","retarcorp-dev-2018");
$link->select_db("desktop.rent");
$res = $link->query("SELECT * FROM test");;
print_r($res);
//print_r($link);?> ;