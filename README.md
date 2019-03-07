# Borsch Framework

Borsch is a nano framework that helps you to kick start your application efficiently.  

## Context

Let's face it, it is 2019 and PHP is not good anymore to build a full website.  
Template engines are outdated and are now replaced by JavaScript framework, faster and more powerful.  

The bright side is that PHP is still awesome to create server side services such as APIs.  
PSR is helping a lot about it, every component can be compatible with each others !  

In this context, Borsch was created with the best packages.  
Everything you love and know how to use, grouped in 1 tiny package to help you create your next ideas.

## Installation

[Composer](https://getcomposer.org/) is recommended :
```
composer require borsch/framework
```
 
 ## Usage
 
 Borsch uses `thephpleague/route` package to deal with routes, therefore it looks a lot like [Slim](http://www.slimframework.com).  
 
 #### Basic example :
 
 ```php
 require_once __DIR__.'/vendor/autoload.php';
 
 use Borsch\{App, Factory};
 use Psr\Http\Message\RequestInterface;
 
 $app = new App();
 
 $app->get('/', function (RequestInterface $request) {
     $response = Factory::createResponse(200, 'OK');
     $response->getBody()->write('Hello World !');
 
     return $response;
 });
 
 try {
     $app->run();
 } catch (Exception $exception) {
     header('HTTP/1.1 500 Internal Server Error', true, 500);
     // Do something with the catched Exception
     // Log ? Email webmaster ? ...
 }
 ```
 
 #### POST example with JsonStrategy
 
 For more informations about Strategies, see the `thephpleague/route` [documentation](https://github.com/thephpleague/route/blob/master/docs/4.x/strategies.md).

```php
 require_once __DIR__.'/vendor/autoload.php';

 use Borsch\{App, Factory};
 use League\Route\Strategy\JsonStrategy;
 use Psr\Http\Message\RequestInterface;

 $app = new App();

 $app->post('/users', function (RequestInterface $request) {
     $data = json_decode($request->getBody()->getContents(), true);
    
     return [
         'user' => [
             'firstname' => $data['user']['firstname'] ?? 'John',
             'lastname' => $data['user']['lastname'] ?? 'Doe',
             'created_at' => date('c'),
             'updated_at' => date('c')
         ]
     ];
})->setStrategy(new JsonStrategy(Factory::getFactory()));

try {
 $app->run();
} catch (Exception $exception) {
 header('HTTP/1.1 500 Internal Server Error', true, 500);
 // Do something with the catched Exception
 // Log ? Email webmaster ? ...
}
```
 
 ## Packages used
 
* league/route
* nyholm/psr7
* nyholm/psr7-server
