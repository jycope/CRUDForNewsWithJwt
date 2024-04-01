CRUD для новостей. Имеет авторизацию и регистрацию пользователей череp JWT.

Инструкция по запуску

1.  Прописать в .env: базу данных **DB_DATABASE**, username от базы данных **DB_USERNAME** и пароль **DB_PASSWORD**
2.  Установить зависимости **composer install**
3. **php artisan migrate**
4. запустить php artisan serve
5. сгенерировать jwt-токен php artisan jwt:secret

Инструкция по проекту:
Тесты находятся tests/Unit/News.Test. Здесь находятся тесты на регистрацию и авторизацию, так же тестирование удаление, создания, чтения и обновления

в App/Http/Controllers два контроллера: AuthController по авторизации пользователя и NewsController контроллер новостей

Нужно зарегистрировать пользователя по пути api/register передав параметры name. email, password. Далее нужно передать эти поля для входа по адресу api/login,  в ответе будет access_token который нужно передавать к следующим адресам:

POST
/api/news - создание новости

PUT
/api/news/{news} - изменение новости

DELETE
/api/news/{news} - удаление новости

Так же есть документация api: openapi.json и openapi.yaml, файлы можно загрузить в editor для удобного просмотра https://editor.swagger.io/

Либо воспользоваться хостингом: http://dmitr1ig.beget.tech/public_html/api/
