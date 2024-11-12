BUILD_DIR := dist
SRC_FILES := $(wildcard *.php) $(wildcard *.css) robots.txt LICENSE
SRC_FILES := $(filter-out config.php, $(SRC_FILES))

.PHONY: build clean deploy

build: $(SRC_FILES)
	mkdir -p $(BUILD_DIR)
	cp $^ $(BUILD_DIR)

clean:
	rm -rf $(BUILD_DIR)

# Deploy to lcat.dev
deploy: build
	rsync -rzh --stats $(BUILD_DIR)/ lcat.dev:/home/public/
