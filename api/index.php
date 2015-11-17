<?php
require 'vendor/autoload.php';
require 'database/ConnectionFactory.php';
require 'guests/GuestService.php';

$app = new \Slim\Slim();

// http://hostname/api/
$app->get('/', function() use ( $app ) {
    echo "Welcome to Guest REST API about second exam!!!";
});

/*
HTTP GET /api/guests
RESPONSE 200 OK 
[
  {
    "id": "1",
    "name": "Lidy Segura",
    "email": "lidyber@gmail.com"
  },
  {
    "id": "2",
    "name": "Edy Segura",
    "email": "edysegura@gmail.com"
  }
*/
  

$app->get('/guests/', function() use ( $app ) {
    $guests = GuestService::listGuests();
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($guests);
});

$app->get('/guests/:id', function($id) use ( $app ) {
    $guest = GuestService::getById($id);
    
    if($guest) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($guest);
    }
    else {
        $app->response()->setStatus(204);
    }
});

/*
HTTP POST /api/guests
REQUEST Body 
{
	"name": "Lidy Segura",
	"email": "lidyber@gmail.com"
}

RESPONSE 200 OK 
{
  "name": "This is a test",
  "email": "test@gmail.com",
  "id": "1"
}
*/
$app->post('/guests/', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $newGuest = json_decode($guestJson, true);
    if($newGuest) {
        $guest = GuestService::add($newGuest);
        echo "Guest {$guest['name']} added on database";
    }
    else {
        $app->response->setStatus(400);
        echo "Invalid JSON";
    }
});

$app->put('/guests/', function() use ( $app ) {
    $guestJson = $app->request()->getBody();
    $updatedGuest = json_decode($guestJson, true);
    
    if($updatedGuest && $updatedGuest['id']) {
        if(GuestService::update($updatedGuest)) {
          echo "Guest {$updatedGuest['name']} updated on database";  
        }
        else {
          $app->response->setStatus('404');
          echo "Guest not found";
        }
    }
    else {
        $app->response->setStatus(400);
        echo "Invalid JSON";
    }
});

/*
HTTP DELETE /api/guests/:id
RESPONSE 200 OK 
{
  "status": "true",
  "message": "Guest deleted!"
}

HTTP DELETE /api/guests/x
RESPONSE 404 NOT FOUND 
{
  "status": "false",
  "message": "Guest with x does not exit"
}
*/

$app->delete('/guests/:id', function($id) use ( $app ) {
    if(GuestService::delete($id)) {
      echo "Guest deleted!";
    }
    else {
      $app->response->setStatus('404');
      echo "Guest with id = $id does not exit";
    }
});

$app->run();
?>