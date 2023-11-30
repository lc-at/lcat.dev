package core

import (
	"database/sql"
	_ "github.com/mattn/go-sqlite3"
	"net/http"

	"codeberg.org/fj/lcat.dev/internal/config"
	"codeberg.org/fj/lcat.dev/internal/front"
	"codeberg.org/fj/lcat.dev/internal/logpost"
	"codeberg.org/fj/lcat.dev/internal/views"
)

type App struct {
	mux    *http.ServeMux
	config *config.Config
}

func New(config *config.Config) (app *App, err error) {
	app = &App{
		mux:    http.NewServeMux(),
		config: config,
	}

	db, err := sql.Open("sqlite3", config.DatabasePath)
	if err != nil {
		return
	}

	logpostManager := logpost.NewManager(db)
	templateManager := views.NewManager(config.TemplatesDir, config.Debug)

	frontHandler := front.New(templateManager, logpostManager)
	frontHandler.Register(app.mux)

	return
}

func (app *App) ListenAndServe() error {
	return http.ListenAndServe(app.config.ListenAddr, app.mux)
}
