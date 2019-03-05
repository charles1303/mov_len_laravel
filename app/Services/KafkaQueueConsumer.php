<?php
namespace App\Services;

use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Log;
use Kafka\Consumer as KafkaConsumer;
use Kafka\ConsumerConfig as KafkaConsumerConfig;

/**
 *
 * @author charles
 *        
 */
class KafkaQueueConsumer
{

    protected $consumer;
    
    /**
     */
    public function __construct()
    {
        
        $config = KafkaConsumerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setGroupId('test');
        $config->setBrokerVersion('1.0.0');
        $config->setTopics(['test']);
        $this->consumer = new KafkaConsumer();
        
    }
    
    public function consumeMessages()
    {
        
        
            $this->consumer->start(function($topic, $part, $message) {
                if($message){
                    $object = json_decode($message['message']['value']);
                    Log::channel('daily')->info('Consumer messages received.....' . $object->age);
                    //var_dump($object->age);
                }
                
            }, true);
        
    }
}

