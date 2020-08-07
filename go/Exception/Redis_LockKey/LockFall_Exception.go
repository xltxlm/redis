package Exception/Redis_LockKey

type LockFall_Exception struct {
    /*  */
    RedisConfig 

    /*  */
    Redis_LockKey 

}

func NewLockFall_Exception(RedisConfig ,Redis_LockKey ) *LockFall_Exception{
    var this = new(LockFall_Exception)
    this.SetRedisConfig(RedisConfig);
    this.SetRedis_LockKey(Redis_LockKey);
    return this
}

func (this *LockFall_Exception)GetRedisConfig() {
    return this.RedisConfig;
}

func (this *LockFall_Exception)SetRedisConfig(RedisConfig ) *LockFall_Exception{
    this.RedisConfig = RedisConfig;
    return this
}
func (this *LockFall_Exception)GetRedis_LockKey() {
    return this.Redis_LockKey;
}

func (this *LockFall_Exception)SetRedis_LockKey(Redis_LockKey ) *LockFall_Exception{
    this.Redis_LockKey = Redis_LockKey;
    return this
}

