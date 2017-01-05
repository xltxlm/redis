<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 11:02.
 */

namespace xltxlm\redis\Util;

/**
 * 有序队列写入的模型
 * Class ZaddUnit.
 */
final class ZaddUnit
{
    /** @var string 名称 */
    protected $name = '';
    /** @var string 分数 */
    protected $score = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ZaddUnit
     */
    public function setName(string $name): ZaddUnit
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getScore(): string
    {
        return $this->score;
    }

    /**
     * @param string $score
     *
     * @return ZaddUnit
     */
    public function setScore(string $score): ZaddUnit
    {
        $this->score = $score;

        return $this;
    }
}
