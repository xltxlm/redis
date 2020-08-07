package Redis_LockKey

import (
    "libs/redis/go/Features"
    "log"
    )

func Test{"id":"157","project_type":"类库","project_name":"redis","share":"","from_project_name":"","commom_class_id":"0","mark":"锁定函数","dirname":"Features","class_name":"Redis_LockKey","code_type":"类","enums":"","attribute":"Exception_on_LockFail(bool,默认值:)\nexpire(数字,默认值:)\nkey(字符串,默认值:)\nRedisConfig(<span style='color:red'>[Go]<\/span> | <span style='color:green'>\\xltxlm\\redis\\Config\\RedisConfig[PHP]<\/span>,默认值:)\nTry_Wait_Second(数字,默认值:)\nvalue(字符串,默认值:)","method":"#检测是否已经锁住了\n1:__invoke(<span style='color: red'>[PHP]<\/span>,<span style='color: red'>[Go]<\/span>):bool<hr>\n#执行的是事务的时候,还需要主动释放掉key\n2:Free(<span style='color: red'>[PHP]<\/span>,<span style='color: red'>[Go]<\/span>):bool<hr>","moreclass":"","username":"夏琳泰","usernameip":"10.10.12.45","add_time":"2018-10-31 18:28:58","update_time":"2018-11-01 16:22:13","elasticsearch":"未索引","phphead":"","gohead":"","commom_class_id_ext":"0","classs_name_ext":"","interface":"0","latest_result":"<hr>\n<b>func __invoke<\/b>\n112:检测是否已经锁住了@key不存在的情况下,能正常锁定和释放@__invoke_63\n@2018-11-01 16:16:39\n113:检测是否已经锁住了@测试key不存在的时候,锁定成功.并且释放成功@__invoke_64\n@2018-11-01 16:21:00\n<hr>\n<b>func Free<\/b>\n","generatingcode":"生成","idea_make":"待定"}(){
    log.SetFlags(log.Lshortfile | log.LstdFlags)
}
