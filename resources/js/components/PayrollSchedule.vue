<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Set Payroll Schedule
                        <div class="card-tools">
                            <router-link to="/payslipManage"
                                ><button class="btn btn-info">
                                    <i class="fas fa-arrow-left fa-fw"></i>
                                    Go Back
                                </button></router-link
                            >
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Payroll Schedule:</th>
                                    <th>
                                        <div class="form-group">
                                            <input
                                                v-model="form.payroll_name"
                                                type="text"
                                                placeholder="Payroll Schedule"
                                                name="payroll_name"
                                                id="payroll_name"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'payroll_name'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="payroll_name"
                                            ></has-error>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Employee</th>
                                    <th>Daily Rate</th>
                                    <th>Hourse Worked</th>
                                    <th>Overtime</th>
                                    <th>Benefit Deduction</th>
                                    <th>Other Deduction</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="payslip in payslips"
                                    :key="payslip.id"
                                >
                                    <td>
                                        {{ payslip.employment.user.name }}
                                    </td>
                                    <td>
                                        {{
                                            ((payslip.employment.position
                                                .salary *
                                                12) /
                                                261)
                                                | amountFilter
                                        }}
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input
                                                v-model="form.hours_worked"
                                                type="text"
                                                placeholder="Total hours worked"
                                                name="hours_worked[index]"
                                                id="hours_worked[index]"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'hours_worked'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="hours_worked"
                                            ></has-error>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
            editMode: true,
            payslips: {},
            form: new Form({
                id: "",
                payroll_name: "",
                employment_id: "",
                rate: "",
                hours_worked: "",
                overtime: "",
                benefit_deduction: "",
                other_deduction: ""
            })
        };
    },
    methods: {
        loadPayslip() {
            axios.get("api/payroll").then(({ data }) => {
                this.payslips = data.data;
            });
        }
    } /* end of methods */,
    created() {
        this.loadPayslip();
        Fire.$on("UserAction", () => {
            this.loadPayslip();
        });
    }
};
</script>
