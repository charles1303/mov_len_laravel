<?php
namespace App\Http\Controllers\Age;


use Kafka\ConsumerConfig as Kconfig;
use Kafka\Consumer as Kconsumer;
/**
 *
 * @author charles
 *        
 */
class QConsumer
{

    // TODO - Insert your code here
    
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function consume()
    {
        $config = Kconfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setGroupId('test');
        $config->setBrokerVersion('1.0.0');
        $config->setTopics(['test']);
        $consumer = new Kconsumer();
        
        $consumer->start(function($topic, $part, $message) {
            var_dump($message);
        });
    }
}

$obj = new QConsumer();
echo $obj->consume();