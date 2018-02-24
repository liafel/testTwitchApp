<p align="center">
Задание
</p>

## О приложении

Приложение построено на laravel 5.6. 
Собирает информацию по стримам онлайн на сервисе Twitch.tv.

## Регистрация
Регистрация реализована через стандартные средства laravel. 

## Список игр
Авторизованный пользователь может добавить игру для отслеживания на странице /games. Список игр подгружается с сервиса twitch.tv

## Сбор данных
Сбор данных организован через консольную команду php artisan get:streamdata.
В файле Kernel.php настроен сбор данных по играм каждые 10 минут: $schedule->command('get:streamdata')->everyTenMinutes()->timezone('Europe/Moscow');
Для сбора необходимо прописать в системном кроне
* * * * * php /var/www/html-twitch/artisan schedule:run >> /dev/null 2>&1

## Токен
Доступ к api осуществляется через get запрос по адресу /api. Для доступа необходим сгенерированный токен. Токен генерируется авторизованным пользователем на странице /home. Пример запроса к api через curl:
```
curl -X GET \
  'http://twit.ch/api?type=streams&date_from=2018-01-01' \
  -H 'Accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQxZWE5ODQ0YjNhM2E0Yzc3ZDRhZDY4NjY2YjAzNDNlOTQ3OTQwMzQzZTE5MGJiNzIxZDBkYmU4Y2ExNTY5ZTQwZDY5NjM3MDAxYzMxMGEzIn0.eyJhdWQiOiIxIiwianRpIjoiZDFlYTk4NDRiM2EzYTRjNzdkNGFkNjg2NjZiMDM0M2U5NDc5NDAzNDNlMTkwYmI3MjFkMGRiZThjYTE1NjllNDBkNjk2MzcwMDFjMzEwYTMiLCJpYXQiOjE1MTk0NTk2NjEsIm5iZiI6MTUxOTQ1OTY2MSwiZXhwIjoxNTUwOTk1NjYxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.RBuFMLjqvyCtNkBaGfEW3cSTsxF2WolNKSepLAZzDHqnnu5Jhaq_nLWj5yaE_oG6BX5cNrTAuvaAtts-UDbMzuFHn5fn_QFhHet68RQUMt1cHqVchAiQzy4x2c8BTSlm1WEYi3pr3prWQki_j2Fd_SS2718EEmCZWce6DbLM2Cb-AHj768lqlSfor34tQP9PpDccOi3Ui6mGxhLWSmzMrzETT6_KATmRnZwkS23k8xnPiVTcW0hRJW7taK83P4Dc1JcYqjswqlceH1IfDiXBFuJw8RWXkk6ioJbvuXdjWaUcoEXCPv3_33dhnR1GQFE_KZzJI0wDKKuAoZOU5TeDiEq3ZfiWH3wtF3A0Yc2lhvzK-VvP1aeWfBG_rIWJjDEZfwKtBzE_7GYsQt_Bodc2rgH_h28nWWrk4KEhTCI0p34iX3dRCtEhbg9DLIGpyZ1irroJEWb3bT8fLZewRXJKxTCOjBH_L-X6OrFZ5KnbRIqXyfu28zjlcmWpqu8w6BgO5J5tlLMpXrAonQ1ogdjGN_502QMDi0c-jGas8xNew2gVS7_P7hlK4uVv6VUzOyS_uUT5T_igl0ipl8jCUwUeU685tLM4URQ49EeWJU24A1LioJWqiEgK34r50C7Houx_ML0_xuVfIqqKbhdDewXB1XkB1x1OQ3i-j836rk1_NiI' \
  -H 'Cache-Control: no-cache' \
  -H 'Content-Type: application/json'
```
Доступные параметры для запроса к api
**type** - обязательный параметр. Влияет на структуру возвращаемого json'a. Доступны 2 варианта: viewers (суммарное количество зрителей) и streams (возвращает id стримов)
**date_from** - дата "ОТ". Необязательный параметр. Дата в формате YYYY-MM-DD, начало интервала дат. Может использоваться без date_to, в таком случае вернет все значения по текущий момент.
**date_to** - дата "ДО". Необязательный параметр. Дата в формате YYYY-MM-DD, конец интервала дат. Может использоваться без date_from, в таком случае вернет все значения с начала сбора данных по заданную дату.
**game_id** - id игры. Необязательный параметр. ID игры в сервисе twitch. Можно использовать несколько раз

Пример запроса к API:
/api?type=viewers&game_id=490422&game_id=11989&game_id=138591&date_from=2018-02-14