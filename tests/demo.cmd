docker run -d -id --name redis1 -p 6379:6379 redis
docker exec -it redis1 redis-cli