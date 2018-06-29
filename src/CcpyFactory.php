<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/6/29
 * Time: 下午3:47
 */
namespace Hycooc\Ccpy;

class CcpyFactory
{
    /**
     * @param array $config
     *
     * @return CcpyInstance
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

        return $this->getCcpyClient($config);
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function getConfig(array $config)
    {
        return [
            'key'   => array_get($config, 'key', ''),
            'value' => array_get($config, 'value', ''),
        ];
    }

    /**
     * @param array $config
     *
     * @return CcpyInstance
     */
    protected function getCcpyClient(array $config)
    {
        return new CcpyInstance($config['key'], $config['value']);
    }
}