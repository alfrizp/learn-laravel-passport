<?php
require "vendor/autoload.php";

$client = new GuzzleHttp\Client;

try {
	$response = $client->post('http://localhost:8000/oauth/token', [
		'form_params' => [
			'client_id' => 2,
			'client_secret' => '6AOj6ywRAdsyTLMfrQvSrjQHA1O1sdvIWGbZf16V',
			'grant_type' => 'password',
			'username' => 'admin@example.com',
			'password' => 'secret',
			'scope' => '*'
		]
	]);

	$auth = json_decode( (string) $response->getBody() );

	$response = $client->get('http://localhost:8000/api/todos', [
		'headers' => [
			'Authorization' => 'Bearer ' . $auth->access_token,
		]
	]);

	$todos = json_decode( (string) $response->getBody() );

	$todoList = "";
	foreach ($todos as $todo) {
		$todoList = "<li>{$todo->task} " . ($todo->done ? "OK" : "") . "</li>";

		echo "<ul>{$todoList}</ul>";
	}

} catch (GuzzleHttp\Exception\BadResponseException $e) {
	echo "Unable to retrieve access token.";
}
?>
