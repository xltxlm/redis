package Features

type Redis_LockKey struct {
    /* 锁定的key */
    key string

    /* 超时时间 */
    expire int

    /* 服务器配置 */
    RedisConfig 

    /* 需要存储的值,默认是当前时间 */
    value string

    /* 如果一次锁不住,希望卡住坚持的秒数 */
    Try_Wait_Second int

    /* 锁定失败的时候,抛出异常 */
    Exception_on_LockFail bool

}

func NewRedis_LockKey(RedisConfig ,Try_Wait_Second int,Exception_on_LockFail bool) *Redis_LockKey{
    var this = new(Redis_LockKey)
    this.SetRedisConfig(RedisConfig);
    this.SetTry_Wait_Second(Try_Wait_Second);
    this.SetException_on_LockFail(Exception_on_LockFail);
    return this
}

func (this *Redis_LockKey)GetRedisConfig() {
    return this.RedisConfig;
}

func (this *Redis_LockKey)SetRedisConfig(RedisConfig ) *Redis_LockKey{
    this.RedisConfig = RedisConfig;
    return this
}
func (this *Redis_LockKey)GetTry_Wait_Second() int{
    return this.Try_Wait_Second;
}

func (this *Redis_LockKey)SetTry_Wait_Second(Try_Wait_Second int) *Redis_LockKey{
    this.Try_Wait_Second = Try_Wait_Second;
    return this
}
func (this *Redis_LockKey)GetException_on_LockFail() bool{
    return this.Exception_on_LockFail;
}

func (this *Redis_LockKey)SetException_on_LockFail(Exception_on_LockFail bool) *Redis_LockKey{
    this.Exception_on_LockFail = Exception_on_LockFail;
    return this
}

/**
    检测是否已经锁住了*/
func (this *Redis_LockKey)__invoke()bool{

}

/**
    执行的是事务的时候,还需要主动释放掉key*/
func (this *Redis_LockKey)Free()bool{

}

