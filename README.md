# rest-react
App should consists from 2 parts: RESTful api service and react as web-interface

# Running:
 - Shoot: ```php -S localhost:8000 -t web-service```
 - dump db
 
# Testing:
**Add films. Works for 1 film same as for several**

``` POST http://localhost:8000/api/films ```

body: 

 - **with key: json_film**

```[{"title":"MYFILM3","release_date":"1234","format":"\u0443\u0446","stars":["New Star22","Clevon Little","Harvey Korman","Gene Wilder","Slim Pickens","Madeline Kahn"]}, {"title":"MYFILM4","release_date":"1234","format":"\u0443\u0446","stars":["New Star1","Clevon Little","Harvey Korman","Gene Wilder","Slim Pickens","Madeline Kahn"]}]```

 - **Get a list of films**

``` GET http://localhost:8000/api/films ```

 - **Delete a film by id**

``` DELETE http://localhost:8000/api/film/1 ```
