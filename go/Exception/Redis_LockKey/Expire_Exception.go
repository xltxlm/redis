package Exception/Redis_LockKey

type Expire_Exception struct {
}

func NewExpire_Exception() *Expire_Exception{
    var this = new(Expire_Exception)
    return this
}


