extern crate cgi;
extern crate lcat_rs;
use minijinja::context;

cgi::cgi_main! {
    |request: cgi::Request| {
        let mut ctx = lcat_rs::get_context();
        let id = request.uri().query().and_then(|q| {
            q.split('&').find_map(|pair| {
                let mut parts = pair.split('=');
                if parts.next()? == "id" {
                    parts.next()
                } else {
                    None
                }
            })
        });

        if id.is_none() {
            return cgi::html_response(400, "Missing id parameter");
        }

        match ctx.get_post_by_id(id.unwrap()) {
            Ok(post) => {
                let tmpl = ctx.mjenv.get_template(lcat_rs::TMPL_POST).unwrap();
                let body = tmpl.render(context! { title => post.title, post => post }).unwrap();
                cgi::html_response(200, body)
            },
            Err(_) => {
                cgi::html_response(404, "Post not found")
            }
        }
    }
}
