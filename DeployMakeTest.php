<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/3/6
 * Time: 17:48
 */

namespace kuaigeng\pushconfig\Config;

use PHPUnit\Framework\TestCase;
use xltxlm\deployer\Deploy\DeployMake;
use xltxlm\deployer\Deploy\DockerVolumes;

/**
 * 测试生成整个服务的部署脚本
 * Class DeployMakeTest
 * @package xltxlm\deployer
 */
class DeployMakeTest extends TestCase
{

    public function test()
    {
        $deployMake = new DeployMake();
        $redis = (new DockerVolumes($deployMake))
            ->setDockerPath("registry-internal.cn-hangzhou.aliyuncs.com/xialintai/redis")
            ->setVolumes("/opt/redis/", "/data/")
            ->setPorts('$ip:6379', 6379)
            ->setEnvFile("env_file.env");
        $deployMake
            ->setTesthost("root@116.62.32.197")
            ->setOnlinehost('root@118.178.129.189')
            ->setOnlinehost('root@118.178.233.122')
            ->setProjectDocker($redis)
            ->__invoke();
    }
}