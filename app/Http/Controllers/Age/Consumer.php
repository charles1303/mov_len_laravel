<?php
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\json_decode;

require '../../../../vendor/autoload.php';
$config = \Kafka\ConsumerConfig::getInstance();
$config->setMetadataRefreshIntervalMs(10000);
$config->setMetadataBrokerList('127.0.0.1:9092');
$config->setGroupId('test');
$config->setBrokerVersion('1.0.0');
$config->setTopics(['test']);
$consumer = new \Kafka\Consumer();

$consumer->start(function($topic, $part, $message) {
    $object = json_decode($message['message']['value']);
    var_dump($object->age);
});
    