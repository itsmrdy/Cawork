<?php 
// require 'vendor/autoload.php';
// use Aws\Exception\AwsException;
// use Aws\Sns\SnsClient;

// error_reporting(0);
// // Pass the provider to the client
// $client = new SnsClient([
// 	'profile' => 'default',
//     'region' => 'us-east-1',
//     'version' => 'latest',
// ]);

// $message = 'This message is sent from a Amazon SNS code sample.';
// $phone = '+639511628072';
// $result = $client->publish([
// 	'Message' => $message,
// 	'PhoneNumber' => $phone,
// ]);
// use Aws\Sns\SnsClient; 
// use Aws\Exception\AwsException;
// use Aws\Credentials\CredentialProvider;

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

// $provider = CredentialProvider::defaultProvider();

// $client = new SnsClient([
// 	// 'credentials' => [
// 	// 	'key' => "AKIA3KTA6G5U6LVJJ7IH", 
// 	// 	'secret' => "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"
// 	// ],
//     'profile' => 'default',
//     'region' => 'us-west-2',
//     'version' => '2010-03-31', 
// 	'credentials' => $provider
// ]);

// $message = 'This message is sent from a Amazon SNS code sample.';
// $phone = '+639511628072';

// try {
//     $result = $client->publish([
//         'Message' => $message,
//         'PhoneNumber' => $phone,
//     ]);
//     var_dump($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     error_log($e->getMessage());
// } 

// $phone_number = "09511628072";
// $message = "Hi this message is auto generated";
// $ch = curl_init();
// $parameters = array(
// 	'apikey' => 'bde93cc086e6dfd3cdff816dfce9c441', //Your API KEY
// 	'number' => $phone_number,
// 	'message' => $message,
// 	'sendername' => 'SEMAPHORE'
// );
// curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
// curl_setopt( $ch, CURLOPT_POST, 1 );
// curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
// $output = curl_exec($ch);

// print($output);
// curl_close ($ch);


?>