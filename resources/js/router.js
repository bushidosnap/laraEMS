import VueRouter from "vue-router";
window.Vue = require("vue").default;

Vue.use(VueRouter);

let routes = [
    {
        path: "/dashboard",
        component: require("./components/Dashboard.vue").default
    },
    {
        path: "/profile",
        component: require("./components/Profile.vue").default
    },
    {
        path: "/users",
        component: require("./components/UsersManagement.vue").default
    },
    {
        path: "/profileManage",
        component: require("./components/ProfileManagement.vue").default
    },
    {
        path: "/employment",
        component: require("./components/Employment.vue").default
    },
    {
        path: "/deptPos",
        component: require("./components/DepartmentPosition.vue").default
    },
    {
        path: "/myPayslip",
        component: require("./components/MyPayslip.vue").default
    },
    {
        path: "/payslipManage",
        component: require("./components/PayslipManagement.vue").default
    },
    {
        path: "/payrollSchedule",
        component: require("./components/PayrollSchedule.vue").default
    }
];

const router = new VueRouter({
    mode: "history",
    routes,
    linkActiveClass: "active"
});

export default router;
