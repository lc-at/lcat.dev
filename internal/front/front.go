package front

import (
	"net/http"

	"codeberg.org/fj/lcat.dev/internal/posts"
	"codeberg.org/fj/lcat.dev/internal/views"
)

type Handler struct {
	viewsManager *views.Manager
	postsManager *posts.Manager
}

func New(viewsManager *views.Manager, postsManager *posts.Manager) *Handler {
	return &Handler{
		viewsManager,
		postsManager,
	}
}

func (h *Handler) Register(mux *http.ServeMux) {
	mux.HandleFunc("/", h.index)
	mux.HandleFunc("/_/", h.viewPost)
}

func (h *Handler) index(w http.ResponseWriter, r *http.Request) {
	if r.URL.Path != "/" {
		h.viewPost(w, r)
		return
	}

	posts, err := h.postsManager.GetAllPinnedFirst(20, 0)
	if err != nil {
		http.Error(w, err.Error(), http.StatusInternalServerError)
		return
	}

	h.viewsManager.Get(views.Index).Execute(w, posts)
}

func (h *Handler) viewPost(w http.ResponseWriter, r *http.Request) {
	post, err := h.postsManager.GetById(r.URL.Path[1:])
	if err != nil {
		http.NotFound(w, r)
		return
	}
	h.viewsManager.Get(views.ViewPost).Execute(w, post)
}
