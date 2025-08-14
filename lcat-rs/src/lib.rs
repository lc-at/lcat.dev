use minijinja::Environment;
use rusqlite::{params, Connection, Result};
use serde::{Deserialize, Serialize};

/**
 * Rust Migration Plan
 * ===================
 * [ ] View post
 * [ ] Adjust Makefile to enable co-existing with PHP
 * [ ] Add .htaccess rule to redirect migrated pages
 * [ ] List posts/index
 * [ ] Contact page
 * [ ] Login page
 * [ ] Decide session management and message handling
 * [ ] Add/edit/delete post
 * [ ] Refactor if necessary
 * [ ] Shrink size by compiling lib.rs as a shared library
 */

pub const TMPL_BASE: &str = "base";
pub const TMPL_POST: &str = "post";

#[derive(Serialize, Deserialize, Debug)]
pub struct Post {
    pub id: String,
    pub created_at: String,
    pub updated_at: String,
    pub title: String,
    pub content: String,
    pub is_pinned: bool,
}

pub struct Config {
    db_file: String,
    base_url: String,
}

pub struct Context {
    pub config: Config,
    pub mjenv: Environment<'static>,
    db: Option<Connection>,
}

impl Context {
    pub fn new(config: Config) -> Self {
        let mut env = Environment::new();
        /* TODO: Add option to dynamically load templates */
        env.add_template(TMPL_BASE, include_str!("templates/base.html"))
            .unwrap();
        env.add_template(TMPL_POST, include_str!("templates/post.html"))
            .unwrap();

        env.add_global("base_url", &config.base_url);

        Context {
            config,
            mjenv: env,
            db: None,
        }
    }

    fn get_or_create_db(&mut self) -> Result<&Connection> {
        if self.db.is_none() {
            let conn = Connection::open(&self.config.db_file)?;
            self.db = Some(conn);
        }
        Ok(self.db.as_ref().unwrap())
    }

    pub fn get_post_by_id(&mut self, id: &str) -> Result<Post> {
        let conn = self.get_or_create_db()?;
        let mut stmt = conn.prepare(
            "SELECT id, created_at, updated_at, title, content, is_pinned FROM log_post WHERE id = ?",
        )?;
        let post = stmt.query_row(params![id], |row| {
            Ok(Post {
                id: row.get(0)?,
                created_at: row.get(1)?,
                updated_at: row.get(2)?,
                title: row.get(3)?,
                content: row.get(4)?,
                is_pinned: row.get(5)?,
            })
        })?;
        Ok(post)
    }
}

pub fn get_context() -> Context {
    let config = Config {
        db_file: option_env!("LCAT_DB_FILE").unwrap_or("lcat.db").to_string(),
        base_url: option_env!("LCAT_BASE_URL").unwrap_or("/lcat/").to_string(),
    };
    Context::new(config)
}
