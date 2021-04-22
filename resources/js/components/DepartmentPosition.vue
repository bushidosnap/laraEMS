<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Department Management</h3>
                        <div class="card-tools">
                            <button
                                class="btn btn-success"
                                @click="createDeptModal"
                            >
                                <i class="fas fa-building fa-fw"></i> Add
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="department in departments"
                                    :key="department.id"
                                >
                                    <td>{{ department.id }}</td>
                                    <td>{{ department.dept_name }}</td>
                                    <td>
                                        <a
                                            href="#"
                                            @click="editDeptModal(department)"
                                        >
                                            <i class="fa fa-edit"></i
                                        ></a>
                                        |
                                        <a
                                            href="#"
                                            @click="deleteDept(department.id)"
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
            <div class="col-md-6">
                <Position></Position>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="deptModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="DeptLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-show="editMode"
                            class="modal-title"
                            id="DeptLabel"
                        >
                            Update Department
                        </h5>
                        <h5
                            v-show="!editMode"
                            class="modal-title"
                            id="DeptLabel"
                        >
                            Add Department
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
                        @submit.prevent="editMode ? updateDept() : createDept()"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    v-model="form.dept_name"
                                    type="text"
                                    placeholder="Department Name"
                                    name="dept_name"
                                    id="dept_name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'dept_name'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="dept_name"
                                ></has-error>
                            </div>
                            <!-- end of name field -->
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
</template>

<script>
export default {
    data() {
        return {
            editMode: true,
            departments: {},
            form: new Form({
                id: "",
                dept_name: ""
            })
        };
    },
    methods: {
        createDeptModal() {
            this.form.reset();
            this.editMode = false;
            $("#deptModal").modal("show");
        },
        editDeptModal(department) {
            this.form.reset();
            this.editMode = true;
            this.form.fill(department);
            $("#deptModal").modal("show");
        },
        updateDept() {
            this.$Progress.start();
            this.form
                .put("api/department/" + this.form.id)
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#deptModal").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "Department Updated Successfully"
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
        loadDept() {
            axios.get("api/department").then(({ data }) => {
                this.departments = data.data;
            });
        },
        createDept() {
            this.$Progress.start();
            this.form
                .post("api/department")
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#deptModal").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "Department Created Successfully"
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
        } /* end of createUser */,
        deleteDept(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                //send request to the server
                if (result.isConfirmed) {
                    this.form
                        .delete("api/department/" + id)
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("UserAction");
                        })
                        .catch(() => {
                            swal.fire(
                                "Failed!",
                                "There was something wrong.",
                                "warning"
                            );
                        });
                }
            });
        } /* end of deleteUser */
    } /* end of methods */,
    created() {
        this.loadDept();
        Fire.$on("UserAction", () => {
            this.loadDept();
        });
    }
};
</script>
