### Step 1: composer require acolyte/laravel-errorlog 
### Step 2: php artisan vendor:publish
### Step 3: php artisan migrate
### Step 4: php artisan config:cache
### Step 5: Update the .env file with below config

MAIL_FROM_ADDRESS= 

MAIL_FROM_NAME=

MAIL_TO_ADDRESS=

MAIL_CC_ADDRESS=

ROUTE_PREFIX=

MIDDLEWARE=

### Step 6: use Acolyte\ErrorLog\Helpers\SendMails;

### Step 7: 

try {

 // TODO
 
}catch ( \Exception $e) {

   SendMails::sendErrorMail($e->getMessage(), null, 'ErrorLogController', 'errorLogs', $e->getLine(), $e->getFile(),
        '', '', '', '');
    
    return back();

}


