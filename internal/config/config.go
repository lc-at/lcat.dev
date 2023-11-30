package config

import (
	"codeberg.org/fj/lcat.dev/internal/constants"
	"os"
)

type Config struct {
	ListenAddr   string
	DatabasePath string
	TemplatesDir string
	Debug        bool
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
	config.DatabasePath = getEnvOrDefault("DATABASE_PATH", constants.DefaultDatabasePath)
	config.TemplatesDir = getEnvOrDefault("TEMPLATES_DIR", constants.DefaultTemplatesDir)

	if getEnvOrDefault("DEBUG", "") == "1" {
		config.Debug = true
	} else {
		config.Debug = constants.DefaultDebug
	}
	return
}
