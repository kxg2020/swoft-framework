<?php

namespace Swoft\Event\Listeners;

use Swoft\App;
use Swoft\Core\RequestContext;
use Swoft\Bean\Annotation\Listener;
use Swoft\Event\EventInterface;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\AppEvent;

/**
 * 请求前
 *
 * @Listener(AppEvent::BEFORE_REQUEST)
 * @uses      BeforeRequestListener
 * @version   2017年08月30日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 Swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class BeforeRequestListener implements EventHandlerInterface
{
    /**
     * 事件回调
     *
     * @param EventInterface $event      事件对象
     * @return void
     */
    public function handle(EventInterface $event)
    {
        // header获取日志ID和spanid请求跨度ID
        $logid = RequestContext::getRequest()->getHeaderLine('logid');
        $spanid = RequestContext::getRequest()->getHeaderLine('spanid');
        if (empty($logid)) {
            $logid = uniqid();
        }
        if (empty($spanid)) {
            $spanid = 0;
        }
        $uri = RequestContext::getRequest()->getUri();

        $contextData = [
            'logid'       => $logid,
            'spanid'      => $spanid,
            'uri'         => $uri,
            'requestTime' => microtime(true),
        ];

        RequestContext::setContextData($contextData);
    }
}
