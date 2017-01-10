cd %~dp0

rem window下有毛病,以下命令人肉一个一个拷贝运行,验证结论

run.cmd
rem 测试redis容器的持久化: 写入一个key
docker exec -it docker_redis_1 bash -c "redis-cli set a b"
rem 关闭容器
docker-compose down

rem 打开容器
run.cmd
rem 测试之前的值
docker exec -it docker_redis_1 bash -c "redis-cli get a"