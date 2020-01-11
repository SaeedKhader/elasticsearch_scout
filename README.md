

## How To Use
- Run ``` composer install```
- download [sakila database](https://dev.mysql.com/doc/index-other.html).
- Be sure that elasticsearch is running on the 9200 port or you can change the port to yours in scout_elastic.php.
- Run ``` php artisan elastic:create-index "App\FilmIndexConfigurator" ``` to create the films index.
- Run ``` php artisan elastic:update-mapping "App\Film" ``` for the mapping of the films.
- Finally Run ``` php artisan scout:import "App\Film"   ``` to index all films.


