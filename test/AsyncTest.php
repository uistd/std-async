<?php

require_once '../vendor/autoload.php';
\FFan\Std\Common\Config::init(array(
    'env' => 'dev'
));

new \FFan\Std\Logger\FileLogger('logs');
function test1()
{
    echo 'this is test1', PHP_EOL;
}

function test2()
{
    echo 'This is test2', PHP_EOL;
}

\FFan\Std\Async\AsyncCall::setCallback('test1', 'test1');
\FFan\Std\Async\AsyncCall::setCallback('test2', 'test2');

\FFan\Std\Event\EventManager::instance()->trigger(\FFan\Std\Event\EventDriver::EVENT_COMMIT);
