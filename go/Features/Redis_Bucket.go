package Features

type Redis_Bucket struct {
    /*  */
    RedisConfig 

    /* 最大存储元素个数 */
    maxtimes int

    /* 追加新元素 */
    value 

    /* 过期时间 */
    expire int

    /* 正在缓存的key */
    realkey string

    /* 超速之后是否抛出异常 */
    Exception_on_LockFail bool

    /* 要限制的标志位 */
    key string

    /* 取回所有已经存储的元素 */
    AllItems array

    /* 剩余可用量 */
    Remain_num int

    /* 已消耗量 */
    Consumed_num int

}

func NewRedis_Bucket(RedisConfig ,Exception_on_LockFail bool,AllItems array,Remain_num int,Consumed_num int) *Redis_Bucket{
    var this = new(Redis_Bucket)
    this.SetRedisConfig(RedisConfig);
    this.SetException_on_LockFail(Exception_on_LockFail);
    this.SetAllItems(AllItems);
    this.SetRemain_num(Remain_num);
    this.SetConsumed_num(Consumed_num);
    return this
}

func (this *Redis_Bucket)GetRedisConfig() {
    return this.RedisConfig;
}

func (this *Redis_Bucket)SetRedisConfig(RedisConfig ) *Redis_Bucket{
    this.RedisConfig = RedisConfig;
    return this
}
func (this *Redis_Bucket)GetException_on_LockFail() bool{
    return this.Exception_on_LockFail;
}

func (this *Redis_Bucket)SetException_on_LockFail(Exception_on_LockFail bool) *Redis_Bucket{
    this.Exception_on_LockFail = Exception_on_LockFail;
    return this
}
func (this *Redis_Bucket)GetAllItems() array{
    return this.AllItems;
}

func (this *Redis_Bucket)SetAllItems(AllItems array) *Redis_Bucket{
    this.AllItems = AllItems;
    return this
}
func (this *Redis_Bucket)GetRemain_num() int{
    return this.Remain_num;
}

func (this *Redis_Bucket)SetRemain_num(Remain_num int) *Redis_Bucket{
    this.Remain_num = Remain_num;
    return this
}
func (this *Redis_Bucket)GetConsumed_num() int{
    return this.Consumed_num;
}

func (this *Redis_Bucket)SetConsumed_num(Consumed_num int) *Redis_Bucket{
    this.Consumed_num = Consumed_num;
    return this
}

/**
    确认是否已经满了*/
func (this *Redis_Bucket)__invoke()bool{

}

