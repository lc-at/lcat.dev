package core

import (
	"database/sql"
	_ "github.com/mattn/go-sqlite3"
	"net/http"
	"net/http/cgi"

	"codeberg.org/fj/lcat.dev/internal/config"
	"codeberg.org/fj/lcat.dev/internal/front"
	"codeberg.org/fj/lcat.dev/internal/posts"
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

	postsManager := posts.NewManager(db)
	viewsManager := views.NewManager(config.TemplatesDir, config.Debug)

	frontHandler := front.New(viewsManager, postsManager)
	frontHandler.Register(app.mux)

	return
}

func (app *App) Run() error {
	if app.config.ListenAddr == "cgi" {
		return cgi.Serve(app.mux)
	}
	return http.ListenAndServe(app.config.ListenAddr, app.mux)
}
