package 

type RedisCache struct {
    /*  */
    key string

    /*  */
    RedisConfig 

    /* 过期时间,默认是一天 */
    expire int

    /* 用于判断是否已经命中缓存了 */
    cached bool

    /* 需要缓存起来的值 */
    value 

}

func NewRedisCache(RedisConfig ) *RedisCache{
    var this = new(RedisCache)
    this.SetRedisConfig(RedisConfig);
    return this
}

func (this *RedisCache)GetRedisConfig() {
    return this.RedisConfig;
}

func (this *RedisCache)SetRedisConfig(RedisConfig ) *RedisCache{
    this.RedisConfig = RedisConfig;
    return this
}

