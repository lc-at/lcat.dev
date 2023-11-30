package front

import (
	"net/http"

	"codeberg.org/fj/lcat.dev/internal/logpost"
	"codeberg.org/fj/lcat.dev/internal/views"
)

type Handler struct {
	viewsManager   *views.Manager
	logpostManager *logpost.Manager
}

func New(viewsManager *views.Manager, logpostManager *logpost.Manager) *Handler {
	return &Handler{
		viewsManager:   viewsManager,
		logpostManager: logpostManager,
	}
}

func (h *Handler) Register(mux *http.ServeMux) {
	mux.HandleFunc("/", h.index)
}

func (h *Handler) index(w http.ResponseWriter, r *http.Request) {
	logposts, err := h.logpostManager.GetAllPinnedFirst(20, 0)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	h.viewsManager.Get(views.Index).Execute(w, logposts)
}
