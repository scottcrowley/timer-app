# Timer App

This is an open source timer app that was built and maintained by Scott Crowley.

## Installation

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart). 

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone git@github.com:scottcrowley/timer-app.git
cd timer-app && composer install && npm install
php artisan timer-app:install
npm run dev
```

### Step 2

Next, boot up a server and visit your timer app. If using a tool like Laravel Valet, of course the URL will default to `http://timer-app.test`. 

1. Visit: `http://timer-app.test/register` to register a new timer app account.
2. Visit: `http://timer-app.test/clients/create` to start adding new clients to the timer app.
