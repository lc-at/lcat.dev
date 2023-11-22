package templates

import "html/template"

const Index = "index"

type Manager struct {
	templates map[string]*template.Template
}

func New(templatesDir string) *Manager {
	t := new(Manager)
	t.templates = make(map[string]*template.Template)
	t.templates[Index] = template.Must(template.ParseFiles(templatesDir + "/index.html"))
	return t
}

func (t *Manager) Get(name string) *template.Template {
	return t.templates[name]
}
