package Features

type SpeedLimiter struct {
    /* Redis配置 */
    RedisConfig 

    /* 要限速的key */
    key string

    /* 限速周期 */
    cycletime int

    /* 周期内最大速率 */
    maxtimes int

    /* 超速了,抛出异常 */
    Exception_on_LockFail bool

    /* 真正存储的key,带上时间概念的 */
    realkey string

}

func NewSpeedLimiter(RedisConfig ,Exception_on_LockFail bool) *SpeedLimiter{
    var this = new(SpeedLimiter)
    this.SetRedisConfig(RedisConfig);
    this.SetException_on_LockFail(Exception_on_LockFail);
    return this
}

func (this *SpeedLimiter)GetRedisConfig() {
    return this.RedisConfig;
}

func (this *SpeedLimiter)SetRedisConfig(RedisConfig ) *SpeedLimiter{
    this.RedisConfig = RedisConfig;
    return this
}
func (this *SpeedLimiter)GetException_on_LockFail() bool{
    return this.Exception_on_LockFail;
}

func (this *SpeedLimiter)SetException_on_LockFail(Exception_on_LockFail bool) *SpeedLimiter{
    this.Exception_on_LockFail = Exception_on_LockFail;
    return this
}

/**
    实现通用的光卡逻辑*/
func (this *SpeedLimiter)__invoke()bool{

}

