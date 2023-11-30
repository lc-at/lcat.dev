package views

import (
	"html/template"
	"path"
)

const Index = "index"

type Manager struct {
	templates     map[string]*template.Template
	templatesDir  string
	alwaysCompile bool
}

func NewManager(templatesDir string, alwaysCompile bool) *Manager {
	t := new(Manager)
	t.templates = make(map[string]*template.Template)
	t.templatesDir = templatesDir
	t.alwaysCompile = alwaysCompile
	t.compile()
	return t
}

func (t *Manager) templateFilename(filename string) string {
	return path.Join(t.templatesDir, filename)
}

func (t *Manager) compile() {
	t.templates[Index] = template.Must(template.ParseFiles(t.templateFilename("index.html")))
}

func (t *Manager) Get(name string) *template.Template {
	if t.alwaysCompile {
		t.compile()
	}
	return t.templates[name]
}
