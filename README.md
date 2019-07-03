# Instructions

Clone or download from:
```https://github.com/kanian/SymfUserManagement/tree/1.0/ ```

Set DB in your .env:
```DATABASE_URL=mysql://youruser:yourpassword@127.0.0.1:3306/symfuserman```

On the command line, in the installation folder, do:
```$ composer install
$ ./bin/console doctrine:database:create
$ ./bin/console doctrine:migrations:migrate
$ ./bin/console doctrine:fixtures:load
```
To login:
```curl --location --request POST "symfusermanagement.localhost/login" \
  --header "Content-Type: application/json" \
  --data "{
    \"username\": \"admin@example.com\",
    \"password\": \"admin\"
}"
```

API Docs at:
```https://documenter.getpostman.com/view/7129706/S1a91Qs4```