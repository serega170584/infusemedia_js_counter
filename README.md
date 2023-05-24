# infusemedia counter
infusemedia counter

- Deploy environment


        docker-compose build --no-cache && docker-compose up  

- Enter inside container


        docker-compose exec backend sh

- Upload database through dump file


        mysql -h db --user=root --password=secret infusemedia < dump.sql

- External host for mysql - localhost:3300, user - root, password - secret, database - infusemedia


- Visit pages http://localhost:3100/index.html and we can see view_count changes in table logs.

- We can see directories js, src, index.html inside frontend directory. main.php and dump.sql with other code files inside backend directory.

- We can also delete stop docker compose

        docker-compose down