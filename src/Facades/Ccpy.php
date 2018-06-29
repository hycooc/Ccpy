<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/6/29
 * Time: 下午3:35
 */

namespace Hycooc\Ccpy\Facades;

use Illuminate\Support\Facades\Facade;

class Ccpy extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ccpy';
    }
}