<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Position Management</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="createPosModal">
                        <i class="fas fa-certificate fa-fw"></i> Add
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
                            <th>Salary</th>
                            <th>Modify</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="position in positions" :key="position.id">
                            <td>{{ position.id }}</td>
                            <td>{{ position.position_name }}</td>
                            <td>{{ position.salary | amountFilter }}</td>
                            <td>
                                <a href="#" @click="editPosModal(position)">
                                    <i class="fa fa-edit"></i
                                ></a>
                                |
                                <a href="#" @click="deleteDept(position.id)">
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
        <!-- Modal -->
        <div
            class="modal fade"
            id="posModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="posModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-show="editMode"
                            class="modal-title"
                            id="posModalLabel"
                        >
                            Update Position
                        </h5>
                        <h5
                            v-show="!editMode"
                            class="modal-title"
                            id="posModalLabel"
                        >
                            Add Position
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
                        @submit.prevent="editMode ? updatePos() : createPos()"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    v-model="form.position_name"
                                    type="text"
                                    placeholder="Position Name"
                                    name="position_name"
                                    id="position_name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'position_name'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="position_name"
                                ></has-error>
                            </div>
                            <!-- end of position_name field -->
                            <div class="form-group">
                                <input
                                    v-model="form.salary"
                                    type="text"
                                    placeholder="Salary"
                                    name="salary"
                                    id="salary"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('salary')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="salary"
                                ></has-error>
                            </div>
                            <!-- end of salary field -->
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
            positions: {},
            form: new Form({
                id: "",
                position_name: "",
                salary: ""
            })
        };
    },
    methods: {
        createPosModal() {
            this.form.reset();
            this.editMode = false;
            $("#posModal").modal("show");
        },
        editPosModal(position) {
            this.form.reset();
            this.editMode = true;
            this.form.fill(position);
            $("#posModal").modal("show");
        },
        updatePos() {
            this.$Progress.start();
            this.form
                .put("api/position/" + this.form.id)
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#posModal").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "Department Updated Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    $("#posModal").modal("hide");
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });
        },
        loadPos() {
            axios.get("api/position").then(({ data }) => {
                this.positions = data.data;
            });
        },
        createPos() {
            this.$Progress.start();
            this.form
                .post("api/position")
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#posModal").modal("hide");
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
        } /* end of createUser */,
        deletePos(id) {
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
                        .delete("api/position/" + id)
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
        this.loadPos();
        Fire.$on("UserAction", () => {
            this.loadPos();
        });
    }
};
</script>
