package Config

type RedisConfig struct {
    /* 链接日志,延迟到功能注销之后才执行,否则因为日志写入之前需要链接redis,造成死循环 */
    connectlog 

}

func NewRedisConfig() *RedisConfig{
    var this = new(RedisConfig)
    return this
}


/**
    测试服务是否正常*/
func (this *RedisConfig)Test()bool{

}

/**
    创建新链接*/
func (this *RedisConfig)NewConnect(){

}

