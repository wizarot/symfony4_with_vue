import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Posts from "../views/Posts";
import Login from "../views/Login";
import store from "../store";

Vue.use(VueRouter);

let router = new VueRouter({
  mode: "history",
  routes: [
    { path: "/home", component: Home },
    { path: "/login", component: Login },
    { path: "/posts", component: Posts, meta: { requiresAuth: true } },
    { path: "*", redirect: "/home" }
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters["security/isAuthenticated"]) {
      next();
    } else {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    }
  } else {
    next(); // make sure to always call next()!
  }
});

export default router;
