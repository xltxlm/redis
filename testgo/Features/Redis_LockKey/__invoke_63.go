package Redis_LockKey

import (
    "libs/redis/go/Features"
    "log"
    )

func Test{"id":"157","project_type":"类库","project_name":"redis","share":"","from_project_name":"","commom_class_id":"0","mark":"锁定函数","dirname":"Features","class_name":"Redis_LockKey","code_type":"类","enums":"","attribute":"expire(数字,默认值:)\nkey(字符串,默认值:)\nRedisConfig(<span style='color:red'>[Go]<\/span> | <span style='color:green'>\\xltxlm\\redis\\Config\\RedisConfig[PHP]<\/span>,默认值:)\nTry_Wait_Second(数字,默认值:)\nvalue(字符串,默认值:)","method":"#检测是否已经锁住了\n1:__invoke(<span style='color: red'>[PHP]<\/span>,<span style='color: red'>[Go]<\/span>):bool<hr>\n#执行的是事务的时候,还需要主动释放掉key\n2:Free(<span style='color: red'>[PHP]<\/span>,<span style='color: red'>[Go]<\/span>):bool<hr>","moreclass":"","username":"夏琳泰","usernameip":"10.10.12.45","add_time":"2018-10-31 18:28:58","update_time":"2018-11-01 11:55:29","elasticsearch":"未索引","phphead":"","gohead":"","commom_class_id_ext":"0","classs_name_ext":"","interface":"0","latest_result":"","generatingcode":"生成","idea_make":"待定"}(){
    log.SetFlags(log.Lshortfile | log.LstdFlags)
}
