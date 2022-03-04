# contact-form
Simple Contact form created using the Symfony PHP framework

# Setup
First lets install all dependencies:
Run the following commands in the project root directory:
> composer install<br>
> npm install <br>

Then lets build our resources
> npm run dev <br>

A `docker-compose` file is used to create a `PostgreSQL` database container and a [sj26/mailcatcher](link=https://github.com/sj26/mailcatcher) container.
So while in the project root directory, run: 

>docker-compose up -d

to create and start the containers in daemon mode.

Let us now run our serve our project

> symfony server:start

and navigate to `http://localhost:8000/` in your web browser.

You can immediately start creating messages on the contact form.
When you need to login, register a user first. The user won't have the needed `role` to access all the posts. So run the following command to update the user's role

>php bin/console doctrine:query:sql "update \"user\" set roles = '[\"ROLE_ADMIN\"]' where email = '\<YOUR EMAIL HERE\>'"


To see the email that was sent after a post was made, navigate to `http://127.0.0.1:1080/`. The mail catcher should have caught the mail and you can now view it.

# Tech
- Symfony 6 PHP Framework
- Vue 2.6 JS Framework
- Axios HTTP Client
- Bulma CSS Framework
- Fontawesome images
- Docker Compose
- PostgreSQL
