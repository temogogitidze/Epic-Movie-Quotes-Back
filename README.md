# Epic Movie Quotes

> This is server-side part of Epic Movie Quotes application. Application gives opportunity to add
> movies/quotes/comments/likes and sends notifications in live regime.

## Table of Contents

* [General Info](#general-information)
* [Prerequisites](#prerequisites)
* [Tech Stack](#tech-stack)
* [Getting Started](#getting-started)
* [Development](#development)
* [Features](#features)
* [DrawSQL](#drawSQL)
* [Project Status](#project-status)
* [Room for Improvement](#room-for-improvement)
* [Acknowledgements](#acknowledgements)
* [Contact](#contact)

## General Information

- My first full-stack project written in Vue + Laravel. This bilingual (EN, KA) application includes many functions such
  as register, reset
  password, login, add/edit/delete movies/quotes and react to them by commenting or liking. Also there's built in
  functionality of live notifications. Application is using Laravel Socialite in order to give user opportunity to login
  with gmail. Application is responsive and supports mobile and high resolution screen views. Application also includes
  Swagger UI for every backend API route

## Prerequisites

- PHP v8 and up
- MySQL v8.0.3 and up
- Composer - v2.4.0 and up
- Node - v14.20.0 and up
- npm@6 and up

## Tech Stack

Used dependencies :

- Laravel - version 9.26.1
- Laravel Echo
- Pusher JS
- Laravel Socialite
- Firebase / php-jwt
- Swagger

Installation :

- Laravel - https://laravel.com/docs/9.x/installation#main-content
- Laravel Echo - https://www.npmjs.com/package/laravel-echo
- Pusher JS - https://www.npmjs.com/package/pusher-js
- Laravel Socialite - https://laravel.com/docs/9.x/socialite
- Firebase JWT - https://github.com/firebase/php-jwt
- Swagger -https://swagger.io/docs/open-source-tools/swagger-ui/usage/installation/

## Getting Started

1) First of all, clone Epic Movie Quotes repository from Github:

   `https://github.com/RedberryInternship/temo-gogitidze-epic-movie-quotes-back.git`

2) Install all the dependencies :

   `composer install`

3) Install all the JS dependencies :

   `npm install`

4) Set our env file. Run this command to the root of your project :

   `cp .env.example .env`

5) Generate key :

   `php artisan key:generate`

6) Migration :

   `php artisan migrate`

7) Run Laravel's built-in development server:

   `php artisan serve`

8) Run swagger server:

   `npm run dev`

## Development

`php artisan serve` - In project root to start build development server

## Features

List the ready features here:

- Register/Login user.
- Verification emails.
- Reset password.
- Search movies/quotes
- Remember me function.
- Supported with 2 languages (EN, KA).
- Swagger UI for API routes
- Edit user's personal information
- Single user can have multiple secondary and one primary email
- Live regime notifications for posts

## DrawSQL

- DrawSQL Link : https://drawsql.app/teams/team-seven/diagrams/epic-movie-quotes

## Project Status

Project is: complete

## Room for Improvement

Room for improvement:

- Loading spinners
- Display flags

## Acknowledgements

- This project was inspired by RedBerry.
- Project design : https://www.figma.com/file/5uMXCg3itJwpzh9cVIK3hA/Movie-Quotes-Bootcamp-assignment?node-id=0%3A1

## Contact

Created by Temo Gogitidze - +995(591 94 32 99)
