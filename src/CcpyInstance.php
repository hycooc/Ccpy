<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/6/29
 * Time: 下午3:47
 */
namespace Hycooc\Ccpy;

class CcpyInstance
{
    protected $key = '';

    protected $value = '';

    /**
     * CcpyInstance constructor.
     *
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;

        $this->value = $value;
    }

    /**
     * @param $str
     * @param string $code
     *
     * @return mixed
     */
    public function pinyin($str, $code = 'gb2312')
    {
        $tDataKey = explode('|', $this->key);

        $tDataValue = explode('|', $this->value);

        $data = array_combine($tDataKey, $tDataValue);

        arsort($data);

        reset($data);

        if ($code != 'gb2312') $str = $this->_U2_Utf8_Gb($str);

        $res = '';

        for ($i = 0; $i < strlen($str); $i++) {
            $p = ord(substr($str, $i, 1));

            if ($p > 160) {
                $q = ord(substr($str, ++$i, 1));
                $p = $p * 256 + $q - 65536;
            }

            $res .= $this->_pinyin($p, $data);
        }

        return preg_replace("/[^a-z0-9]*/", '', $res);
    }

    /**
     * @param $num
     * @param $data
     *
     * @return int|string
     */
    private function _pinyin($num, $data)
    {
        if ($num > 0 && $num < 160) {
            return chr($num);
        } elseif ($num < -20319 || $num > -10247) {
            return '';
        } else {
            $k = '';

            foreach ($data as $k => $v) {
                if ($v <= $num) break;
            }

            return $k;
        }
    }

    /**
     * @param $_C
     *
     * @return string
     */
    public function _U2_Utf8_Gb($_C)
    {
        $str = '';

        if ($str < 0x80) {
            $str .= $_C;
        } elseif ($str < 0x800) {
            $str .= chr(0xC0 | $_C >> 6);

            $str .= chr(0x80 | $_C & 0x3F);
        } elseif ($str < 0x10000) {
            $str .= chr(0xE0 | $_C >> 12);

            $str .= chr(0x80 | $_C >> 6 & 0x3F);

            $str .= chr(0x80 | $_C & 0x3F);

        } elseif ($str < 0x200000) {
            $str .= chr(0xF0 | $_C >> 18);

            $str .= chr(0x80 | $_C >> 12 & 0x3F);

            $str .= chr(0x80 | $_C >> 6 & 0x3F);

            $str .= chr(0x80 | $_C & 0x3F);
        }

        return iconv('UTF-8', 'gbk', $str);
    }
}