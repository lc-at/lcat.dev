package logpost

import "database/sql"

type Model struct {
	id         int
	title      string
	pinned     bool
	content    string
	created_at string
	updated_at string
}

type Manager struct {
	db *sql.DB
}

func NewManager(db *sql.DB) *Manager {
	return &Manager{db: db}
}

func (m *Manager) GetAll() (posts []Model, err error) {
	rows, err := m.db.Query("SELECT * FROM log_posts")
	if err != nil {
		panic(err)
	}
	defer rows.Close()

	for rows.Next() {
		var post Model
		err := rows.Scan(&post.id, &post.title, &post.pinned, &post.content, &post.created_at, &post.updated_at)
		if err != nil {
			panic(err)
		}
		posts = append(posts, post)
	}

	return
}
