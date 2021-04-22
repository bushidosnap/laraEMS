<template>
    <div class="container">
        <div v-if="!$gate.isAdminManager()">
            <notFound></notFound>
        </div>

        <div class="row mt-5" v-if="$gate.isAdminManager()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Employment Management</h3>
                        <div class="card-tools">
                            <button
                                class="btn btn-success"
                                @click="createModal"
                            >
                                <i class="fas fa-user-plus fa-fw"></i> Add
                                Employment
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Emp Type</th>
                                    <th>Contract Start</th>
                                    <th>Contract End</th>
                                    <th>Status</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="employment in employments"
                                    :key="employment.id"
                                >
                                    <td>{{ employment.user.name }}</td>
                                    <td>
                                        {{ employment.department.dept_name }}
                                    </td>
                                    <td>
                                        {{ employment.position.position_name }}
                                    </td>
                                    <td>
                                        {{ employment.emp_type | upFirstWord }}
                                    </td>
                                    <td>
                                        {{
                                            employment.contract_start
                                                | customDate
                                        }}
                                    </td>
                                    <td>
                                        {{
                                            employment.contract_end | customDate
                                        }}
                                    </td>
                                    <td>
                                        {{
                                            employment.status
                                                ? "Active"
                                                : "Inactive"
                                        }}
                                    </td>
                                    <td>
                                        <a
                                            href="#"
                                            @click="editModal(employment)"
                                        >
                                            <i class="fa fa-edit"></i
                                        ></a>
                                        |
                                        <a
                                            href="#"
                                            @click="
                                                deleteEmployment(employment.id)
                                            "
                                        >
                                            <i class="fa fa-trash color-red"></i
                                        ></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- end of col -->
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="addEmployment"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addEmploymentLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-show="editMode"
                            class="modal-title"
                            id="addEmploymentLabel"
                        >
                            Update Employment Info
                        </h5>
                        <h5
                            v-show="!editMode"
                            class="modal-title"
                            id="addEmploymentLabel"
                        >
                            Add New Employment
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- end of modal header -->
                    <form
                        @submit.prevent="
                            editMode ? updateEmployment() : createEmployment()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="user_id"
                                    id="user_id"
                                    v-model="form.user_id"
                                    :class="{
                                        'is-invalid': form.errors.has('user_id')
                                    }"
                                >
                                    <option disabled selected value
                                        >-- Select Employee--</option
                                    >
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                        >{{ user.name }}</option
                                    >
                                </select>
                                <has-error
                                    :form="form"
                                    field="user_id"
                                ></has-error>
                            </div>
                            <!-- end of department field -->
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="dept_id"
                                    id="dept_id"
                                    v-model="form.dept_id"
                                    :class="{
                                        'is-invalid': form.errors.has('dept_id')
                                    }"
                                >
                                    <option disabled selected value
                                        >-- Select Department--</option
                                    >
                                    <option
                                        v-for="department in departments"
                                        :key="department.id"
                                        :value="department.id"
                                        >{{ department.dept_name }}</option
                                    >
                                </select>
                                <has-error
                                    :form="form"
                                    field="dept_id"
                                ></has-error>
                            </div>
                            <!-- end of department field -->
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="pos_id"
                                    id="pos_id"
                                    v-model="form.pos_id"
                                    :class="{
                                        'is-invalid': form.errors.has('pos_id')
                                    }"
                                >
                                    <option disabled selected value
                                        >-- Select Position / Rank--</option
                                    >
                                    <option
                                        v-for="position in positions"
                                        :key="position.id"
                                        :value="position.id"
                                        >{{ position.position_name }}</option
                                    >
                                </select>
                                <has-error
                                    :form="form"
                                    field="pos_id"
                                ></has-error>
                            </div>
                            <!-- end of position field -->
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="emp_type"
                                    id="emp_type"
                                    v-model="form.emp_type"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'emp_type'
                                        )
                                    }"
                                >
                                    <option disabled selected value
                                        >-- Select Employment Type --</option
                                    >
                                    <option value="part time">Part-Time</option>
                                    <option value="probationary"
                                        >Probationary</option
                                    >
                                    <option value="full time">Full-Time</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="emp_type"
                                ></has-error>
                            </div>
                            <!-- end of emp_type field -->
                            <div class="form-row">
                                <div class="form-group col">
                                    <label
                                        for="contract_start"
                                        class="control-label"
                                        >Contract Start</label
                                    >
                                    <div class="input-group">
                                        <input
                                            type="date"
                                            v-model="form.contract_start"
                                            name="contract_start"
                                            id="contract_start"
                                            class="form-control"
                                            data-inputmask="'alias': 'mm/dd/yyyy'"
                                            data-mask=""
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'contract_start'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="contract_start"
                                        >
                                        </has-error>
                                    </div>
                                </div>
                                <!-- end of column contract start -->
                                <div class="form-group col">
                                    <label
                                        for="contract_end"
                                        class="control-label"
                                        >Contract End</label
                                    >
                                    <div class="input-group">
                                        <input
                                            type="date"
                                            v-model="form.contract_end"
                                            name="contract_end"
                                            id="contract_end"
                                            class="form-control"
                                            data-inputmask="'alias': 'mm/dd/yyyy'"
                                            data-mask=""
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'contract_end'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="contract_end"
                                        >
                                        </has-error>
                                    </div>
                                </div>
                                <!-- end of column contract end -->
                            </div>
                            <!-- end of form row -->
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="status"
                                    id="status"
                                    v-model="form.status"
                                    :class="{
                                        'is-invalid': form.errors.has('status')
                                    }"
                                >
                                    <option :value="1" selected>Active</option>
                                    <option :value="0">Inactive</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="status"
                                ></has-error>
                            </div>
                            <!-- end of status field -->
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
                            <button
                                v-show="editMode"
                                type="submit"
                                class="btn btn-success"
                            >
                                Update
                            </button>
                            <button
                                v-show="!editMode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Create
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
    <!-- end of container -->
</template>

<script>
export default {
    data() {
        return {
            editMode: true,
            users: {},
            positions: {},
            departments: {},
            employments: {},
            form: new Form({
                id: "",
                user_id: "",
                dept_id: "",
                pos_id: "",
                emp_type: "",
                contract_start: "",
                contract_end: "",
                status: ""
            })
        };
    },
    methods: {
        createModal() {
            this.form.reset();
            this.editMode = false;
            $("#addEmployment").modal("show");
        },
        editModal(employment) {
            this.form.reset();
            this.editMode = true;
            this.form.fill(employment);
            $("#addEmployment").modal("show");
        },
        updateEmployment() {
            this.$Progress.start();
            this.form
                .put("api/employment/" + this.form.id)
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#addEmployment").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "User Updated Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });
        },
        loadUsers() {
            axios.get("api/user").then(({ data }) => {
                this.users = data.data;
            });
        },
        loadPositions() {
            axios.get("api/position").then(({ data }) => {
                this.positions = data.data;
            });
        },
        loadDepartments() {
            axios.get("api/department").then(({ data }) => {
                this.departments = data.data;
            });
        },
        loadEmployments() {
            axios.get("api/employment").then(({ data }) => {
                this.employments = data.data;
            });
        },
        createEmployment() {
            this.$Progress.start();
            this.form
                .post("api/employment")
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#addEmployment").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "User Created Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });
        } /* end of createUser */
        // deleteUser(id) {
        //     swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then(result => {
        //         //send request to the server
        //         if (result.isConfirmed) {
        //             this.form
        //                 .delete("api/user/" + id)
        //                 .then(() => {
        //                     swal.fire(
        //                         "Deleted!",
        //                         "Your file has been deleted.",
        //                         "success"
        //                     );
        //                     Fire.$emit("UserAction");
        //                 })
        //                 .catch(() => {
        //                     swal.fire(
        //                         "Failed!",
        //                         "There was something wrong.",
        //                         "warning"
        //                     );
        //                 });
        //         }
        //     });
        // } /* end of deleteUser */
    } /* end of methods */,
    created() {
        this.loadUsers();
        this.loadPositions();
        this.loadDepartments();
        this.loadEmployments();
        Fire.$on("UserAction", () => {
            this.loadUsers();
            this.loadPositions();
            this.loadDepartments();
            this.loadEmployments();
        });
    }
};
</script>
