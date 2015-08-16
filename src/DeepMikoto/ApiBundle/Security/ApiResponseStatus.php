<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 6/28/2015
 * Time: 07:18
 */

namespace DeepMikoto\ApiBundle\Security;

/**
 * Class ApiResponseStatus
 * codes and messages used for api responses
 *
 * @package DeepMikoto\ApiBundle\Security
 */
class ApiResponseStatus
{
    const STATUS_OK = 'ok';
    const STATUS_INVALID = 'invalid';

    public static $ALL_OK = [
        'code'      => 46,
        'status'    => self::STATUS_OK
    ];

    public static $USER_NOT_AUTHENTICATED = [
        'code'      => 1,
        'status'    => self::STATUS_INVALID,
        'text'      => 'user is not authenticated'
    ];

    public static $INVALID_REQUEST_METHOD = [
        'code'      => 2,
        'status'    => self::STATUS_INVALID,
        'text'      => 'invalid request method'
    ];

    public static $MISSING_REQUEST_PARAMETERS = [
        'code'      => 3,
        'status'    => self::STATUS_INVALID,
        'text'      => 'required parameters missing from request'
    ];

    public static $INVALID_REQUEST_PARAMETERS = [
        'code'      => 4,
        'status'    => self::STATUS_INVALID,
        'text'      => 'provided parameters are invalid'
    ];

    public static $ACTION_NOT_ALLOWED = [
        'code'      => 5,
        'status'    => self::STATUS_INVALID,
        'text'      => 'user not allowed to perform requested action'
    ];
}