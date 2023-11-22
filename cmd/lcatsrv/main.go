package main

import (
	"codeberg.org/fj/lcat.dev/internal/config"
	"codeberg.org/fj/lcat.dev/internal/core"

	"log"
)

func main() {
	config, err := config.NewFromEnv()
	if err != nil {
		log.Fatalln("Error loading config:", err)
	}

	app, err := core.New(config)
	if err != nil {
		log.Fatalln("Error creating app:", err)
	}

	log.Println("Listening on address", config.ListenAddr)

	log.Fatalln("Error starting server:", app.ListenAndServe())
}
