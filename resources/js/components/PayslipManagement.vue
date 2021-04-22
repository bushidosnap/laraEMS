<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payslip Inventory</h3>
                        <div class="card-tools">
                            <button
                                class="btn btn-success"
                                @click="createPayrollModal()"
                            >
                                <i class="fas fa-file-invoice-dollar fa-fw"></i>
                                Set Payroll Schedule
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Payroll Schedule</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="payslip in payslips"
                                    :key="payslip.id"
                                >
                                    <td>{{ payslip.id }}</td>
                                    <td>{{ payslip.payroll_name }}</td>
                                    <td>{{ payslip.employment.user.name }}</td>
                                    <td>
                                        {{
                                            payslip.employment.department
                                                .dept_name
                                        }}
                                    </td>
                                    <td>
                                        {{
                                            payslip.employment.position
                                                .position_name
                                        }}
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div
            class="modal fade"
            id="payrollSchedModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="payrollschedLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoLabel">
                            Import Payroll Schedule
                        </h5>

                        <a :href="'/storage/payrollFile/Payroll_Format.xlsx'"
                            >Download Payroll Format</a
                        >
                    </div>
                    <!-- end of modal header -->
                    <form
                        @submit.prevent="uploadPayrollFile"
                        enctype="multipart/form-data"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <label
                                    for="excelFile"
                                    class="col-md-12 control-label"
                                    >Upload Excel File</label
                                >
                                <div class="col-sm-12">
                                    <input
                                        type="file"
                                        name="file"
                                        ref="file"
                                        id="file"
                                        v-on:change="selectFile"
                                        class="form-input"
                                    />
                                </div>
                                <has-error
                                    :form="form"
                                    field="excelFile"
                                ></has-error>
                            </div>
                        </div>
                        <!-- end of modal body -->
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                Set Payroll
                            </button>
                        </div>
                        <!-- end of modal footer -->
                    </form>
                    <!-- end of form -->
                </div>
                <!-- end of modal content -->
            </div>
            <!-- end of modal dialog -->
        </div>
        <!-- end of modal -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            payslips: {},
            form: new Form({
                file: ""
            })
        };
    },
    methods: {
        loadPayslip() {
            axios.get("api/payroll").then(({ data }) => {
                this.payslips = data.data;
            });
        },
        createPayrollModal() {
            this.form.reset();
            $("#payrollSchedModal").modal("show");
        },
        uploadPayrollFile(e) {
            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { "content-type": "multipart/form-data" }
            };

            let formData = new FormData();
            formData.append("file", this.form.file);

            axios
                .post("api/payroll", formData, config)
                .then(function(response) {
                    currentObj.success = response.data.success;
                    console.log(response);
                    Fire.$emit("UserAction");
                    swal.fire({
                        icon: "success",
                        title: response.data.success
                    });
                    $("#payrollSchedModal").modal("hide");
                })
                .catch(function(response) {
                    currentObj.output = error;
                    swal.fire("Failed!", error, "warning");
                    $("#payrollSchedModal").modal("hide");
                });
        },
        selectFile(e) {
            this.form.file = e.target.files[0];
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
