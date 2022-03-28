# blog_docker
После скачивания репозитория
cd docker/ 
Выполнить docker-compose up
docker exec -it php /bin/bash
php bin/console doctrine:migrations:migrate
php bin/console --env=dev doctrine:fixtures:load

Пример адресной строки:
http://localhost:8080/news/1
http://localhost:8080/news/1?tags='business'&date='2014-12'
