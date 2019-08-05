# Instructions

Clone or download from:
```https://github.com/kanian/SymfUserManagement/master/ ```

Set DB in your .env:
```DATABASE_URL=mysql://youruser:yourpassword@127.0.0.1:3306/symfuserman```

On the command line, in the installation folder, do:
```$ composer install
$ ./bin/console doctrine:database:create
$ ./bin/console doctrine:migrations:migrate
$ ./bin/console doctrine:fixtures:load
```
To login:
```
Example using Symfony 4 :

use Symfony\Component\HttpClient\HttpClient;

$httpClient = HttpClient::create();
$response = $httpClient->request('POST', '127.0.0.1:8000/login_check',  [
    'headers' => [
        'Content-Type' => 'application/json',
    ],
    'json' => ['username' => 'admin@example.com', 'password' => 'admin'],
  ]);

//Authentication is done through httponly cookie JWT (https://www.youtube.com/watch?v=uboIb2__qqs)
//For all URLs, replace host and port by your own.
//Data and URL parameters are given as an example only.
```

API Docs at:
```https://documenter.getpostman.com/view/7129706/S1a91Qs4```