import json
import time
import pika

def callback(ch, method, properties, body):
    try:
        message = json.loads(body)
        event_type = message.get('type', 'unknown')
        print(f" [x] Outbox event received: {event_type}")
    except json.JSONDecodeError:
        print(f" [x] Outbox message received (non-JSON): {body.decode(errors='replace')}")
    finally:
        ch.basic_ack(delivery_tag=method.delivery_tag)

def main():
    while True:
        try:
            connection = pika.BlockingConnection(pika.ConnectionParameters(host='rabbitmq'))
            channel = connection.channel()

            channel.queue_declare(queue='outbox', durable=True)

            channel.basic_consume(queue='outbox', on_message_callback=callback)

            print(' [*] Python worker waiting for messages on "outbox". To exit press CTRL+C')
            channel.start_consuming()
        except pika.exceptions.AMQPConnectionError:
            print("Connection to RabbitMQ failed. Retrying in 5 seconds...")
            time.sleep(5)


if __name__ == '__main__':
    main()
