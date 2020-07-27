## Description

This test task has completed using PHP7.4, Symfony5.1, PHPUnit and Docker.

#Deploy and command start

Using Docker.

1) Go to project folder.

2) Run: `docker-compose up -d --build`

3) Run composer `docker-compose exec php composer install`

4) Run command `docker-compose exec php php bin/console cleaning:robot path-to-input-file path-to-output-file`

4) Run tests `docker-compose exec php php bin/phpunit`

path-to-input-file: Path to input file
path-to-output-file: Path to output file

We can also run command without params, command just take file in a root of project source.json and command push result 
to result.json

#Deploy and command start without Docker:

If you want to run command without docker you need:

1) Set up php7.4 in your operation system

2) Set up composer

3) Run in folder of project `composer install`

4) Run in folder of project `php bin/console cleaning:robot path-to-input-file path-to-output-file`

5) Run tests `php  bin/phpunit`

