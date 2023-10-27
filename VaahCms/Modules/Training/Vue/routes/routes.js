let routes= [];

import dashboard from "./vue-routes-dashboard";
import practice from "./vue-routes-practices";

routes = routes.concat(dashboard);

routes =routes.concat(practice);

export default routes;
