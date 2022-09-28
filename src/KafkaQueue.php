<?php

namespace Kafka;

use Illuminate\Queue\Queue;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class KafkaQueue extends Queue implements QueueContract
{
    /**
     * Kafka consumer.
     */
    protected $consumer;

    /**
     * Kafka producer.
     */
    protected $producer;

    /**
     * Create a new instance.
     *
     * @param  $producer
     * @param  $consumer
     * @return void
     */
    public function __construct($producer, $consumer)
    {
        $this->producer = $producer;
        $this->consumer = $consumer;
    }

    /**
     * Kafka queue size.
     *
     * @param  $queue
     * @return void
     */
    public function size($queue = null)
    {
        //
    }

    /**
     * Push data to the queue.
     *
     * @param  $job
     * @param  $data
     * @param  $queue
     * @return void
     */
    public function push($job, $data = '', $queue = null)
    {
        $topic = $this->producer->newTopic($queue ?? env('KAFKA_QUEUE'));
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, serialize($job));
        $this->producer->flush(1000);
    }

    /**
     * Push data to the queue.
     *
     * @param  $payload
     * @param  $queue
     * @param  array $options
     * @return void
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        //
    }

    /**
     * Push data to the queue.
     *
     * @param  $delay
     * @param  $job
     * @param  $data
     * @param  $queue
     * @return void
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        //
    }

    /**
     * Pop data to the queue.
     *
     * @param  $queue
     * @throws \Exception
     * @return void
     */
    public function pop($queue = null)
    {
        $this->consumer->subscribe([$queue]);

        try {
            $message = $this->consumer->consume(120 * 1000);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $job = unserialize($message->payload);
                    $job->handle();
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    var_dump("No more messages; will wait for more\n");
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    var_dump("Timed out\n");
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
                    break;
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
