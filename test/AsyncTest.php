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

function test3($a)
{
    echo $a . PHP_EOL;
}

class TestClass
{
    public static function test4($a)
    {
        echo $a . PHP_EOL;
    }
}

\FFan\Std\Async\AsyncCall::setCallback('test1', 'test1');
\FFan\Std\Async\AsyncCall::setCallback('test2', 'test2');
\FFan\Std\Async\AsyncCall::setCallback('test3', 'test3', 'hello');
\FFan\Std\Async\AsyncCall::setCallback('test4', array('TestClass', 'test4'), 'world');

\FFan\Std\Event\EventManager::instance()->trigger(\FFan\Std\Event\EventDriver::EVENT_COMMIT);
