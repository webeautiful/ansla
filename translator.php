<?php
/*
* /usr/local/php56/bin/php -f translator.php batch 2016_tw
* 脚本运行环境与2016_tw为同一级目录
*/
require 'fanJianConvert.php';

switch($argv[1]){
    case 'batch':
        $rootDir = $argv[2];//要遍历的目录
        tree($rootDir, function($filename){
            convertor($filename);
        });
        break;
    case 'one':
        $file = $argv[2];
        convertor($file);
        break;
    default:
        die("参数格式错误!");
        break;
}
function convertor($filename){
    if(file_exists($filename)){
        $htmlBuffer = readHtml($filename);
        $htmlBuffer = FanJianConvert::simple2tradition($htmlBuffer);
        if(outputHtml($filename, $htmlBuffer)){
            echo 'Convert '.$filename.' successfully!'."\n";
        }else{
            echo 'Convert '.$filename.' failure!'."\n";
        }
    }else{
        echo 'Cannot find this file :'.$filename."\n";
    }
}

function readHtml($filename){
    $data = '';
    $data = file_get_contents($filename);
    return $data;
}

function outputHtml($filename, $data){
    return file_put_contents($filename, $data);
}

/**********************
目录递归函数
实现办法：用dir返回对象
***********************/
function tree($directory, $func) 
{ 
    $mydir = dir($directory); 
    while($file = $mydir->read())
    { 
        if($file === '.svn' OR $file === '.' OR $file === '..') continue;
        if((is_dir("$directory/$file"))) 
        {
            tree("$directory/$file", $func); 
        } 
        else 
        $func($directory.'/'.$file);
    } 
    $mydir->close(); 
} 
?>
