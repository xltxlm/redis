package Util

type RedisData struct {
    /* 创建时间 */
    addTime string

    /* 缓存的内容,可以是对象类型 */
    data 

    /* 触发的客户端ip */
    ip string

}

func NewRedisData() *RedisData{
    var this = new(RedisData)
    return this
}


