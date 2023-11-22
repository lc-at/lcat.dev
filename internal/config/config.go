package config

import (
	"codeberg.org/fj/lcat.dev/internal/constants"
	"os"
)

type Config struct {
	ListenAddr string
}

func getEnvOrDefault(key, fallback string) string {
	if value, ok := os.LookupEnv(key); ok {
		return value
	}
	return fallback
}

func NewFromEnv() (config *Config, err error) {
	config = new(Config)
	config.ListenAddr = getEnvOrDefault("LISTEN_ADDR", constants.DefaultListenAddr)

	return
}
