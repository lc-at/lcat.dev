DIST_DIR 		:= dist
CROSS_TARGET		:= x86_64-unknown-freebsd
LCATRS_ROOT		:= ./lcat-rs
LCATRS_RELEASE_DIR 	:= $(LCATRS_ROOT)/target/$(CROSS_TARGET)/release
RUST_SOURCES 		:= $(shell find $(LCATRS_ROOT)/src -type f)

CGI_FILES 	:= $(patsubst $(LCATRS_ROOT)/src/bin/%.rs, %.cgi, $(wildcard $(LCATRS_ROOT)/src/bin/*.rs))
PHP_FILES 	:= $(filter-out config.php, $(wildcard *.php))
STATIC_FILES	:= style.css robots.txt LICENSE

.PHONY: all deploy clean

all: $(addprefix $(DIST_DIR)/, $(CGI_FILES))
	cp $(PHP_FILES) $(STATIC_FILES) $(DIST_DIR)

$(DIST_DIR):
	mkdir -p $(DIST_DIR)

$(DIST_DIR)/%.cgi: $(LCATRS_RELEASE_DIR)/% | $(DIST_DIR)
	cp $< $@

$(LCATRS_RELEASE_DIR)/%: $(RUST_SOURCES)
	cross build --manifest-path $(LCATRS_ROOT)/Cargo.toml --target $(CROSS_TARGET) --release

deploy: all
	rsync -rzh --stats $(DIST_DIR)/ lcat.dev:/home/public

clean:
	rm -rf $(DIST_DIR)
	cross clean --manifest-path $(LCATRS_ROOT)/Cargo.toml --target $(CROSS_TARGET)
