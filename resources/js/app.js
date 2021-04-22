require("./bootstrap");
window.Vue = require("vue").default;
import moment from "moment";
import { Form, HasError, AlertError } from "vform";
import VueProgressBar from "vue-progressbar";
import swal from "sweetalert2";
import router from "./router";
import Gate from "./Gate";
import Vue from "vue";

/* Gate */
Vue.prototype.$gate = new Gate(window.user);

/* V-FORM */
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

/* Vue Progressbar */
Vue.use(VueProgressBar, {
    color: "rgb(143,255,199)",
    failedColor: "red",
    height: "2px"
});

/* Sweet Alert 2 */
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: toast => {
        toast.addEventListener("mouseenter", swal.stopTimer);
        toast.addEventListener("mouseleave", swal.resumeTimer);
    }
});
window.toast = toast;
/* Fire */
window.Fire = new Vue();

/* Vue filter */
Vue.filter("upFirstWord", function(text) {
    if (text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    }
});
Vue.filter("customDate", function(date) {
    if (date) {
        return moment(date).format("MMMM Do YYYY");
    } else {
        return "Update Birth Date";
    }
});
Vue.filter("amountFilter", function(amount) {
    if (amount) {
        //var temp = amount.toString().length;
        var format = new Intl.NumberFormat("en-US", {
            minimumFractionDigits: 2
        });
        return format.format(amount);
    } else {
        return "Update Amount";
    }
});
Vue.filter("payslipFilter", function(payslip) {
    if (payslip) {
        var date = payslip.split("_");
        var date_caps = date[0].charAt(0).toUpperCase() + date[0].slice(1);
        var num = date[1];

        return date_caps + " " + num;
    } else {
        return " ";
    }
});

/* Vue Component */
Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "UserAccountsTab",
    require("./components/UserAccountsTab.vue").default
);

Vue.component("Position", require("./components/Position.vue").default);

Vue.component("notFound", require("./components/NotFound.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router
});
