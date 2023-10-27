let routes= [];

import dashboard from "./vue-routes-dashboard";
import test from "./vue-routes-tests";
import user from "./vue-routes-users";
import taxonomy from "./vue-routes-taxonomies";

routes= routes.concat(test);

routes = routes.concat(dashboard);

routes =routes.concat(user);

routes =routes.concat(taxonomy);

export default routes;
