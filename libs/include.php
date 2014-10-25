<?php
/*
 * Created on 2007-5-14
 * Programmer : Alan , Msn - haowubai@hotmail.com
 * PHP100.com Develop a project PHP - MySQL - Apache
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 include_once('./class/Smarty.class.php');

 //******************
   $smarty = new smarty();
   $smarty->template_dir = './templates/'.$smartytpl;
   $smarty->compile_dir  = './templates_c/';
   $smarty->config_dir   = './config/';
   $smarty->cache_dir    = './cache/';
   $smarty->caching      = false;
   $smarty->left_delimiter = "{";
   $smarty->right_delimiter = "}";
 //******************

?>


