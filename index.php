<?php

require_once("db.php");

$db = new database();
$data =  $db->table('urunler')->select('*')->limit([0,5])->order_by('isim')->run();
//$data =  $db->table('urunler')->select('*')->where(['id' => 5])->run();
//$insert = $db->table('urunler')->insert(['isim'=> 'Apple X' , 'resim' => '3.jpg' , 'fiyat' => '999.00'])->run();

var_dump($data);


$update = $db->table('urunler')
            ->where(['id' => '13'])
            ->update([
                    ['isim' => 'Samsug Galaxy'],
                    ['resim' => 'Samsung.jpg'],
                    ['fiyat' => 555]
                ])
            ->run();

