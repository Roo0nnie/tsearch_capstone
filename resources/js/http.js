/**
 * Axios is loaded globally so Blade pages can continue to make authenticated
 * Laravel requests with the CSRF/XSRF headers already configured.
 */

import axios from "axios";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
