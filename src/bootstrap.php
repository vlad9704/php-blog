<?php

declare(strict_types=1);

use Smarty\Smarty;

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = require __DIR__ . '/db.php';

$smarty = new Smarty();

$smarty->setTemplateDir(dirname(__DIR__) . '/templates');
$smarty->setCompileDir(dirname(__DIR__) . '/var/templates_c');
$smarty->setEscapeHtml(true);