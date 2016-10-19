<?php

namespace DeepMikoto\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExtraLogController
 * @package DeepMikoto\ApiBundle\Controller
 */
class ExtraLogController extends Controller
{
    /**
     * @param array $record
     * @return array
     */
    public function processRecord(array $record)
    {
        $request = Request::createFromGlobals();
        $record['extra']['request_ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unavailable';
        $record['extra']['ClientIp'] = $request->getClientIp();
        $record['extra']['ClientIps'] = $request->getClientIps();
        $record['extra']['Host'] = $request->getHost();
        $record['extra']['HttpHost'] = $request->getHttpHost();
        $record['extra']['RequestUri'] = $request->getRequestUri();
        $record['extra']['getUser'] = $request->getUser();
        $record['extra']['getUserInfo'] = $request->getUserInfo();
        $record['extra']['Port'] = $request->getPort();
        $record['extra']['HEADERS'] = $request->headers;
        $record['extra']['GET'] = $_GET;
        $record['extra']['POST'] = $_POST;
        $record['extra']['ENV'] = $_ENV;
        $record['extra']['COOKIE'] = $_COOKIE;
        $record['extra']['PHP_SELF'] = $_SERVER['PHP_SELF'];

        return $record;
    }
}