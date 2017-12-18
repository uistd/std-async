<?php

require_once '../vendor/autoload.php';
\UiStd\Common\Config::init(array(
    'env' => 'dev'
));

new \UiStd\Logger\FileLogger('logs');
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

\UiStd\Async\AsyncCall::setCallback('test1', 'test1');
\UiStd\Async\AsyncCall::setCallback('test2', 'test2');
\UiStd\Async\AsyncCall::setCallback('test3', 'test3', 'hello');
\UiStd\Async\AsyncCall::setCallback('test4', array('TestClass', 'test4'), 'world');

\UiStd\Event\EventManager::instance()->trigger(\UiStd\Event\EventDriver::EVENT_COMMIT);
