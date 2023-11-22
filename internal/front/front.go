package front

import (
	"net/http"

	"codeberg.org/fj/lcat.dev/internal/logpost"
	"codeberg.org/fj/lcat.dev/internal/templates"
)

type Handler struct {
	tm             *templates.Manager
	logpostManager *logpost.Manager
}

func New(tm *templates.Manager, logpostManager *logpost.Manager) *Handler {
	return &Handler{
		tm:             tm,
		logpostManager: logpostManager,
	}
}

func (h *Handler) Register(mux *http.ServeMux) {
	mux.HandleFunc("/", h.index)
}

func (h *Handler) index(w http.ResponseWriter, r *http.Request) {
	h.tm.Get(templates.Index).Execute(w, nil)
}
