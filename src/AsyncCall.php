<?php

namespace FFan\Std\Async;

use FFan\Std\Event\EventDriver;
use FFan\Std\Event\EventManager;
use FFan\Std\Logger\LogHelper;

/**
 * Class AsyncCall
 * @package FFan\Std\Async
 */
class AsyncCall
{
    /**
     * @var callable[] 回调函数
     */
    private static $async_call_list;

    /**
     * @var bool 是否设置了事件
     */
    private static $is_event_set = false;

    /**
     * 设置一个回调函数
     * @param string $name name 避免重复添加回调函数
     * @param callable $callback 回调函数
     * @param null $args 参数
     */
    public static function setCallback($name, callable $callback, $args = null)
    {
        if (isset(self::$async_call_list[$name])) {
            return;
        }
        //如果是第一次
        if (!self::$is_event_set) {
            EventManager::instance()->attach(EventDriver::EVENT_COMMIT, array('\FFan\Std\Async\AsyncCall', 'call'));
            self::$is_event_set = true;
        }
        if (null === $args) {
            self::$async_call_list[$name] = $callback;
        } else {
            self::$async_call_list[$name] = [$callback, $args];
        }
    }

    /**
     * 执行懒加载
     */
    public static function call()
    {
        if (empty(self::$async_call_list)) {
            return;
        }
        $logger = LogHelper::getLogRouter();
        $all_call_list = self::$async_call_list;
        self::$async_call_list = null;
        //执行回调函数
        foreach ($all_call_list as $name => $call_set) {
            $logger->debug('[Async]Call async callback:' . $name);
            if (is_array($call_set)) {
                call_user_func($call_set[0], $call_set[1]);
            } else {
                call_user_func($call_set);
            }
        }
        //继续调用，因为有可能在执行异步回调的时候，又生成了新的异步回调
        self::call();
    }
}