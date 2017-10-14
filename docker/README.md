1. Build image from Dockerfile (from Dockerfile directory):
docker build -t szutkowski/php:70-zts-pthreads .

2. Enter the container
docker run -v [path to code]:/var/www/html -it szutkowski/php:70-zts-pthreads /bin/bash

3. Start RabbitMQ
docker-compose up

4. Run scripts from `scripts` directory