<?php
/**
 * Created by PhpStorm.
 * User: baoerge
 * Email: baoerge123@163.com
 * Date: 2018/6/29
 * Time: 下午4:17
 */
namespace Hycooc\Ccpy;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class CcpyManager extends AbstractManager
{
    /**
     * @var CcpyFactory
     */
    private $factory;

    public function __construct(Repository $config, CcpyFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * @param array $config
     *
     * @return CcpyInstance
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * @return string
     */
    protected function getConfigName()
    {
        return 'ccpy';
    }

    /**
     * @return CcpyFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}