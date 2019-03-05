<?php
namespace App\Services;



/**
 *
 * @author charles
 *        
 */
class KafkaQueueService
{

    protected $producer;
    /**
     */
    public function __construct()
    {
        /*$config = \Kafka\ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('127.0.0.1:9092');
        $config->setBrokerVersion('1.0.0');
        $config->setRequiredAck(1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);
        $this->producer = new \Kafka\Producer();*/
    }
    
    
    /*public function sendMessage(object $message, string $topic)
    {
            $this->producer->send([
                [
                    'topic' => $topic,
                    'value' => $message,
                    'key' => '',
                ],
            ]);
        
    }*/
}

