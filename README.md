<strong>Tour Management System - Live</strong><br>
<br>
Laravel: 10.48.29<br>
PHP: 8.1.0<br>
DB: MySQL -> PostGres (migration issues fixed for live hosting)<br>
Telescope not included<br>
<br>
GitHub Repo for cloning (includes Telescope): https://github.com/udara-neminda-chandrawansa/tour-mgmt-laravel-render<br>
Live: https://tour-mgmt-laravel-render.onrender.com/<br>
<br>
admin@gmail.com - 12345678<br>
agent1@gmail.com - 12345678<br>
<br>
===========================================================

# Used "Laravel 11 with a Docker PHP Image" as template

A demo repo for deploying a Laravel PHP application on [Render](https://render.com) using Docker. You can follow the getting started tutorial [here](https://render.com/docs/deploy-php-laravel-docker).


## Deployment

1. [Create](https://dashboard.render.com/new/database) a new PostgreSQL database on Render and copy the internal DB URL to use below.

2. Fork this repo to your own GitHub account.

3. Create a new **Web Service** on Render, and give Render's GitHub app permission to access your new repo.

4. Select `Docker` for the environment, and add the following environment variable under the *Advanced* section:

   | Key             | Value           |
   | --------------- | --------------- |
   | `APP_KEY`  | Copy the output of `php artisan key:generate --show` |
   | `DATABASE_URL`  | The **internal database url** for the database you created above. |
   | `DB_CONNECTION`  | `pgsql` |

That's it! Your Laravel 11 app will be live on your Render URL as soon as the build finishes. You can test it out by registering and logging in.
