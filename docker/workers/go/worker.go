package main

import (
	"encoding/json"
	"log"
	"time"

	"github.com/streadway/amqp"
)

type message struct {
	Type    string          `json:"type"`
	Payload json.RawMessage `json:"payload"`
}

func main() {
	for {
		conn, err := amqp.Dial("amqp://guest:guest@rabbitmq:5672/")
		if err != nil {
			log.Printf("Failed to connect to RabbitMQ: %s. Retrying in 5 seconds...", err)
			time.Sleep(5 * time.Second)
			continue
		}
		defer conn.Close()

		ch, err := conn.Channel()
		if err != nil {
			log.Printf("Failed to open a channel: %s", err)
			continue
		}
		defer ch.Close()

		q, err := ch.QueueDeclare(
			"outbox", // name
			true,     // durable
			false,    // delete when unused
			false,    // exclusive
			false,    // no-wait
			nil,      // arguments
		)
		if err != nil {
			log.Printf("Failed to declare a queue: %s", err)
			continue
		}

		msgs, err := ch.Consume(
			q.Name, // queue
			"",     // consumer
			false,  // auto-ack
			false,  // exclusive
			false,  // no-local
			false,  // no-wait
			nil,    // args
		)
		if err != nil {
			log.Printf("Failed to register a consumer: %s", err)
			continue
		}

		log.Printf(" [*] Go worker waiting for messages on %q. To exit press CTRL+C", q.Name)

		for d := range msgs {
			var msg message
			if err := json.Unmarshal(d.Body, &msg); err != nil {
				log.Printf("Outbox message received (non-JSON): %s", d.Body)
				_ = d.Ack(false)
				continue
			}
			log.Printf("Outbox event received: %s", msg.Type)
			_ = d.Ack(false)
		}
	}
}
