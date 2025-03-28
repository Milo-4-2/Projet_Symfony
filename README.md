# __Clone the repository__

Open a terminal, navigate to the folder where you want to store the project, and run :

```sh
git clone https://github.com/Milo-4-2/Projet_Symfony.git
```

# __Requirements__

- ## __PHP__

Make sure you have __`PHP`__ installed on your device : 

```sh
php -v
```

If not, you can download it on [php.net](https://www.php.net/downloads.php).

Make sure to add it to your PATH (usually __`C:\Program Files\PHP`__).

- ## __Composer__

Make sure you have __`Composer`__ installed on your device : 

```sh
composer -v
```

If not, you can download it on [getcomposer.org](https://getcomposer.org/download/).

Make sure to add it to your PATH (usually __`C:\Users\[user name]\AppData\Roaming\Composer\vendor\bin`__).

- ## __Symfony CLI__

Make sure you have __`Symfony`__ installed on your device :

```sh
symfony -v
```

If not, you can see the installation methods on [symfony.com](https://symfony.com/download).

- ## __PHP extensions__

Make sure __`fileinfo`__ and __`gd`__ are enabled.

You can enable these in your __`php.ini`__ file (usually located at __`C:\Program Files\PHP\php.ini`__) by uncommenting these line (remove the semicolons __`;`__) :

```ini
;extension=fileinfo
;extension=gd
```

- ## __Local environment configuration__

Create a __`.env.local`__ file at the root of the project to override environment variables for your machine that contains :

```dotenv
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

- ## __Install dependencies__

Navigate to the project's root and run :

```sh
composer install
```

- ## __Set up the database__

Navigate to the project's root and run :

```sh
symfony console make:migration
symfony console doctrine:migration:migrate
```

# __Run the application__

You can run the application by running the command :

```sh
symfony serve
```

Then access the application in your browser at [localhost:8000](https://localhost:8000).
