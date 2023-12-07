package posts

import "database/sql"

type Model struct {
	Id         string
	Title      string
	Content    string
	IsPinned   bool
	IsMarkdown bool
	CreatedAt  string
	UpdatedAt  string
}

type Manager struct {
	db *sql.DB
}

func NewManager(db *sql.DB) *Manager {
	return &Manager{db: db}
}

func (m *Manager) GetAllPinnedFirst(limit, offset int) (posts []Model, err error) {
	rows, err := m.db.Query(`SELECT id, title, content, COALESCE(is_pinned, FALSE), is_markdown, created, last_updated
                                 FROM log_post 
                                 ORDER BY is_pinned DESC, created DESC
                                 LIMIT ? OFFSET ?`, limit, offset)
	if err != nil {
		panic(err)
	}
	defer rows.Close()

	for rows.Next() {
		var post Model
		err := rows.Scan(&post.Id, &post.Title, &post.Content, &post.IsPinned,
			&post.IsMarkdown, &post.CreatedAt, &post.UpdatedAt)
		if err != nil {
			panic(err)
		}
		posts = append(posts, post)
	}

	return
}

func (m *Manager) GetById(id string) (post Model, err error) {
	err = m.db.QueryRow(`SELECT id, title, content, COALESCE(is_pinned, FALSE), is_markdown, created, last_updated
                             FROM log_post 
                             WHERE id = ?`, id).Scan(&post.Id, &post.Title,
		&post.Content, &post.IsPinned, &post.IsMarkdown,
		&post.CreatedAt, &post.UpdatedAt)
	return
}
