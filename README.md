# Splash - Webbtjänst
av Dennis Kjellin, dekj2100@student.miun.se
Projektuppgift för kursen Fullstacksutveckling med ramverk, Mittunivesitetet Sundsvall, HT 2022.

## Info om webbtjänsten
Moment - 1 av projektuppgiften är att skapa en REST-webbtjänst med full CRUD-funktionalitet baserad på Laravel som backend-ramverk som använder en databas för lagring av data.

Samt funktionalitet för registrering och autentisering av användare.

## Installation av databas
För att ladda ner repot:
```
"git clone https://github.com/Webbutvecklings-programmet/projekt_webservice_vt22-denniskjellin.git"
```

Du behöver installera följande program på din maskin:
```
* Laravel
* Composer
* XAMPP
* PHP
* NodeJS
```
### Efter att du har öppnat projektet i ditt val av kod-editor så gör följande:

Öppna API mappen i din Terminal.
```
cd splashapi
```
Skapa en databas utöver de inloggningsuppgifter som står i .env filen för projektet, alternativt skapa egen DB med egen username och password
```
cp .env.example .env
```
Installera databasen mot XAMPP: php artisan migrate
```
php artisan migrate
```
Starta webbservern: 
```
php artisan serve
```
Du kan nu komma åt servern på http://localhost:8000

Installationen är nu slutförd.

******

## Tabeller som installeras
(Laravel installerar vissa standard tabellern, jag tar upp Users för denna har jag aktivt arbetat med)

|Tabell|Kolumn  |
|--|--|
|Users  | **id** (bigint(20) primary_key auto_increment, **name** varchar(255), not_null, **email** varchar(255), foreign_key, not_null, **email_verified_at** timestamp, nullable, **password** varchar(255) not_null, **remember_token** varchar(100), null_able, **created_at** timestamp, null_able, **updated_at** timestamp, null_able |

******

|Tabell|Kolumn  |
|--|--|
|Suppliers  | **id** (bigint(20) primary_key auto_increment, **name** varchar(255), not_null, **email** varchar(256), not_null, **phone** varchar(12), not_null, **created_at** timestamp, null_able, **updated_at** timestamp, null_able |

|Tabell|Kolumn  |
|--|--|
|Products  | **id** (bigint(20) primary_key auto_increment, **name** varchar(64), not_null, **supplier_id** bigint(20) foreign_key, not_null, **category_id** bigint(20) foreign_key, not_null, **amount** int(11), not_null, **price** int(11), not_null, **image** varchar(250), nullable, **info** longText, not_null, **created_at** timestamp, null_able, **updated_at** timestamp, null_able |

|Tabell|Kolumn  |
|--|--|
|Categories  | **id** (bigint(20) primary_key auto_increment, **name** varchar(64), not_null, **created_at** timestamp, null_able, **updated_at** timestamp, null_able |

******

|Tabell|Kolumn  |
|--|--|
|Posts  | **id** (bigint(20) primary_key auto_increment, **title** varchar(255), not_null, **content** longText, not_null, **created_at** timestamp, null_able, **updated_at** timestamp, null_able |

|Tabell|Kolumn  |
|--|--|
|Comments  | **id** (bigint(20) primary_key auto_increment, **comment** varchar(255), not_null, **post_id** bigint(20) foreign_key, not_null, **created_at** timestamp, null_able, **updated_at** timestamp, null_able |

******

## Mappar
Dessa mappar är de mappar som jag aktivt arbetat i som är bra att ha koll på:

* ```app``` - Innehåller Eloquent models
* ```app/Http/Controllers/Api``` - Innehåller alla controllers
* ```app/Http/Middleware``` - Innehåller auth middleware (autentisering)
* ```database/migrations``` - Innehåller databas migrationer
* ```routes``` - Innehåller alla api routes, som är skapta i api.php filen
* ```public/storage/img/products``` - Innehåller mina produktbilder

## Enviroment variablar
* ```.env``` - I denna fil kan du justera databasanslutningen.
******

## Testkörning API
Starta laravel utvecklingsservern
```php artisan serve```

Åtkomst till api
```http://localhost:8000```


| Required | Key    | Value    |
| ------------- | ------------- | -------- |
| Yes | Content-Type   | application/json   |
| Yes | X-Requested-With   | XMLHttpRequest    |
| Yes | Authorization   | Token    |

******

## Autentisering
Min applikation använder sig utav autentisering via en genererad TOKEN som man får vid registrering samt inloggning av användarkonto. 

Vid testkörning via Thunderclient så klistrar du in den TOKEN som genereras vid registering och inloggning i:
```Thunderclient: Auth->Bearer->token```

Du får då åtkomst att testköra de olika routes som webbtjänsten har.

******

## Användning av API/Routes

### Users
| Metod     | Ändpunkt      | Beskrivning   
| ------------- | ------------- | --------    |
| `POST`        | /register         | `Registrera användare`   |
| `POST`         | /login         | `Logga in`   |
| `POST`         | /logout         | `Logga ut`   |

Skickas som JSON med följande struktur:

Registrera
```
{
   "name" : "John",
   "email" : "johndoe@gmail.com",
   "password" : "password" 
}
```
Logga in
```
{
   email: "johndoe@gmail.com",
   password: "password" 
}
```
******

### Suppliers
| Metod     | Ändpunkt      | Beskrivning   
| ------------- | ------------- | --------    |
| `POST`        | /addsuppliers         | `Addera supplier`   |
| `GET`         | /getsuppliers         | `Hämta alla`   |
| `GET`         | /getsuppliers/ID         | `Hämta specifik`   |
| `DELETE`         | /deletesuppliers/ID         | `Ta bort`   |
| `PUT`         | /updatesuppliers/ID         | `Uppdatera`   |

Skickas som JSON med följande struktur:

POST/PUT
```
{
   "name" : "Example supplier",
   "email" : "supplier@gmail.com",
   "phone" : "12345" 
}
```
```DELETE/PUT görs genom att ange önskat ID på slutet av respektive routes!```

******

### Categories
| Metod     | Ändpunkt      | Beskrivning   
| ------------- | ------------- | --------    |
| `POST`        | /addcategories         | `Addera category`   |
| `GET`         | /getcategories         | `Hämta alla`   |
| `GET`         | /getcategories/ID         | `Hämta specifik`   |
| `DELETE`         | /deletecategories/ID         | `Ta bort`   |
| `PUT`         | /updatecategories/ID         | `Uppdatera`   |

Skickas som JSON med följande struktur:

POST/PUT
```
{
   "name" : "Example supplier", 
}
```
```DELETE/PUT görs genom att ange önskat ID på slutet av respektive routes!```

******

### Products
| Metod     | Ändpunkt      | Beskrivning   
| ------------- | ------------- | --------    |
| `POST`        | /addproducts         | `Addera product`   |
| `GET`         | /getproducts         | `Hämta alla`   |
| `GET`         | /getproducts/ID         | `Hämta specifik`   |
| `GET`         | /getproducts/search/product/{sökord}         | `Sök product`   |
| `DELETE`         | /deleteproducts/ID         | `Ta bort`   |
| `PUT`         | /updateproducts/ID         | `Uppdatera`   |

Skickas som JSON med följande struktur:

POST/PUT
```
{
   "name" : "Example product",
   "supplier_id" : "1",
   "category_id" : "1",
   "amount" : 10,
   "price" : 10,
   "image" : - file - (not required)
   "info" : "description.." 
}
```
```DELETE/PUT görs genom att ange önskat ID på slutet av respektive routes!```

******

### Posts
| Metod     | Ändpunkt      | Beskrivning   
| ------------- | ------------- | --------    |
| `POST`        | /addpost         | `Addera post`   |
| `GET`         | /getposts         | `Hämta alla`   |
| `GET`         | /getposts/ID         | `Hämta specifik`   |
| `DELETE`         | /deletepost/ID         | `Ta bort`   |
| `PUT`         | /updatepost/ID         | `Uppdatera`   |

Skickas som JSON med följande struktur:

POST/PUT
```
{
  "title" : "Example title",
  "content" : "Example comment.."
}
```
```DELETE/PUT görs genom att ange önskat ID på slutet av respektive routes!```

******

### Comments
| Metod     | Ändpunkt      | Beskrivning   
| ------------- | ------------- | --------    |
| `POST`        | /addcomment/ID         | `Addera post`   |
| `GET`         | /getcomments/ID         | `Hämta alla`   |
| `GET`         | /getposts/ID         | `Hämta specifik`   |
| `DELETE`         | /deletepost/ID         | `Ta bort`   |
| `PUT`         | /updatepost/ID         | `Uppdatera`   |

Skickas som JSON med följande struktur:

POST/PUT
```
{
  "comment" : "Example comment.."
}
```
```DELETE/PUT görs genom att ange önskat ID på slutet av respektive routes!```

******

## Inspiration
Har hämtat inspiration till min README fil från [Gothinkster GITHUB](https://github.com/gothinkster/laravel-realworld-example-app/blob/master/readme.md)

### Frågor eller funderingar?
Hör gärna av dig till mig!

### Kontaktuppgifter:
#### e-post: dekj2100@student.miun.se
#### e-post: denniskjellin@hotmail.com


