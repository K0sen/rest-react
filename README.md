# rest-react
App consists of 2 parts: RESTful api service and react as web-interface

# Running:
- Dump db from `film_archive.sql`
- Set your database in `web-service/config/db.php`
- Shoot: `php -S localhost:8000 -t web-service` to up a local server
- And: `php -S localhost:5000 -t front-end/build` to up another local server
 
Now you are able to using your app on `localhost:5000`. 
It will addressing to your api-service on `localhost:8000`.
 
# Using:

Here is some feature you can use: 
- Add a film
- Delete a film
- Load films from file `sample_movies.txt`
- Delete all films
- Search by film name and actor name
- See a list of films and their info
