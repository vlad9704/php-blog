<?php

declare(strict_types=1);

use Smarty\Smarty;

require dirname(__DIR__) . '/vendor/autoload.php';

$smarty = new Smarty();

$smarty->setTemplateDir(dirname(__DIR__) . '/templates');
$smarty->setCompileDir(dirname(__DIR__) . '/var/templates_c');
$smarty->setEscapeHtml(true);

$smarty->assign('title', 'Hello World');

$smarty->display('home.tpl');