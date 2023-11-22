package core

import (
	"database/sql"
	"net/http"

	"codeberg.org/fj/lcat.dev/internal/config"
	"codeberg.org/fj/lcat.dev/internal/front"
	"codeberg.org/fj/lcat.dev/internal/templates"
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
	templateManager := templates.New("web")
        db := sql.Open(k)

	frontHandler := front.New(templateManager)
	frontHandler.Register(app.mux)

	return
}

func (app *App) ListenAndServe() error {
	return http.ListenAndServe(app.config.ListenAddr, app.mux)
}
