<pre>
<?php
include "db_settings.php";

// // event
// $event = new Event(array(
// 	"name" => "A Event",
// 	"date" => "2012-10-12"
// ));
// $event->save();
// 
// // session
// $session = new Session(array(
// 	"title" => "a session"
// ));
// $event->add_session($session);
// print_r($event->session);

// speaker
$helper = new Session(true);
$new_session = $helper->find_by_id(13);
print_r($new_session[0]->speaker);

// $helper = new Event(true);
// $events = $helper->find_by_id(30);
// print_r($events[0]->session);
// $new_session[0]->event;

?>
</pre>
