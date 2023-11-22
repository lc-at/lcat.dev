GO := go
MAIN_PKG_PATH := ./cmd/lcatsrv

run:
	$(GO) run $(MAIN_PKG_PATH)

build:
	$(GO) build -o bin/$(notdir $(MAIN_PKG_PATH)) $(MAIN_PKG_PATH)
