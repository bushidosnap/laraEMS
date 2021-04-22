<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 pt-5 pb-3">
                <div class="card">
                    <div class="card-header" v-if="this.myEmployment[0]">
                        <h4>
                            Name: <b>{{ this.myEmployment[0].user.name }}</b>
                        </h4>
                        <h4>
                            Department:
                            <b>{{
                                this.myEmployment[0].department.dept_name
                            }}</b>
                        </h4>
                        <h4>
                            Daily Rate:
                            <b>{{
                                ((this.myEmployment[0].position.salary * 12) /
                                    261)
                                    | amountFilter
                            }}</b>
                        </h4>
                    </div>
                    <div class="card-header" v-else>
                        <h3>
                            NO EMPLOYMENT AVAILABLE
                        </h3>
                    </div>
                    <div class="card-body" v-if="this.myEmployment[0]">
                        <div class="row align-items-end">
                            <div class="form-group col-md-6">
                                <label>Select Payroll:</label>
                                <select
                                    class="form-control"
                                    name="payrollSelected"
                                    id="payrollSelected"
                                    v-model="payrollSelected"
                                >
                                    <option value="0">Select Payroll</option>
                                    <option
                                        v-for="data in myPayrolls"
                                        :key="data.id"
                                        :value="data.id"
                                        >{{ data.payroll_name }}</option
                                    >
                                </select>
                            </div>
                            <div class="form-group col-md-offset-2 col-md-6">
                                <button
                                    type="submit"
                                    class="btn btn-success"
                                    @click="getPayroll()"
                                >
                                    View</button
                                ><!-- end of update button -->
                            </div>
                        </div>

                        <div class="container" v-if="this.selectedPayroll[0]">
                            <div class="row">
                                <p>
                                    Payroll Schedule:
                                    <b>{{
                                        this.selectedPayroll[0].payroll_name
                                            | payslipFilter
                                    }}</b>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="earningLine"></div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Description</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    Total Hours Worked
                                                </th>
                                                <td>
                                                    {{
                                                        this.selectedPayroll[0]
                                                            .hours_worked
                                                            | amountFilter
                                                    }}
                                                    Hrs
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    Overtime Pay
                                                </th>
                                                <td>
                                                    {{
                                                        this.selectedPayroll[0]
                                                            .overtime
                                                            | amountFilter
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div id="deductLine"></div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Description</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    Benefit
                                                </th>
                                                <td>
                                                    {{
                                                        this.selectedPayroll[0]
                                                            .benefit_deduction
                                                            | amountFilter
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    Other Deduction
                                                </th>
                                                <td>
                                                    {{
                                                        this.selectedPayroll[0]
                                                            .other_deduction
                                                            | amountFilter
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div
                                class="row align-items-end justify-content-around"
                            >
                                <div class="col-md-3" id="totalEarning">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <i
                                                class="nav-icon fas fa-plus fa-3x color-white"
                                            ></i>
                                        </div>
                                        <div class="col-md-9">
                                            <p id="label">TOTAL EARNINGS</p>
                                            <p id="output">
                                                {{
                                                    (this.totalEarn =
                                                        this.selectedPayroll[0]
                                                            .rate *
                                                            this
                                                                .selectedPayroll[0]
                                                                .hours_worked +
                                                        this.selectedPayroll[0]
                                                            .overtime)
                                                        | amountFilter
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="totalDeduct">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <i
                                                class="nav-icon fas fa-minus fa-3x color-white"
                                            ></i>
                                        </div>
                                        <div class="col-md-9">
                                            <p id="label">TOTAL DEDUCTIONS</p>
                                            <p id="output">
                                                {{
                                                    (this.totalDeduct =
                                                        this.selectedPayroll[0]
                                                            .benefit_deduction +
                                                        this.selectedPayroll[0]
                                                            .other_deduction)
                                                        | amountFilter
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="netPay">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <i
                                                class="nav-icon fas fa-money-bill fa-3x color-white"
                                            ></i>
                                        </div>
                                        <div class="col-md 9">
                                            <p id="label">NET PAY</p>
                                            <p id="output">
                                                {{
                                                    (this.totalEarn -
                                                        this.totalDeduct)
                                                        | amountFilter
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            myEmployment: [],
            selectedPayroll: [],
            myPayrolls: [],
            payrollSelected: 0,
            totalEarn: 0,
            totalDeduct: 0,
            form: new Form({
                payroll_name: ""
            })
        };
    },
    methods: {
        loadmyEmployment() {
            axios.get("api/myEmployment").then(data => {
                this.myEmployment = data.data;
                this.form.fill(data.data[0]);
            });
        },
        loadmyPayrolls() {
            axios.get("api/myPayrolls").then(data => {
                this.myPayrolls = data.data;
            });
        },
        getPayroll() {
            axios
                .get("/api/getPayroll", {
                    params: {
                        payroll_id: this.payrollSelected
                    }
                })
                .then(
                    function(response) {
                        this.selectedPayroll = response.data;
                    }.bind(this)
                );
        }
    },
    created() {
        this.loadmyEmployment();
        this.loadmyPayrolls();
    }
};
</script>
