<template>
    <div class="container">
        <div v-if="!$gate.isAdminManager()">
            <notFound></notFound>
        </div>

        <div class="row mt-5" v-if="$gate.isAdminManager()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Management</h3>
                        <div class="card-tools">
                            <button
                                class="btn btn-success"
                                @click="createModal"
                            >
                                <i class="fas fa-user-plus fa-fw"></i> Add New
                                User
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
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>User Creation</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.type | upFirstWord }}</td>
                                    <td>{{ user.created_at | customDate }}</td>
                                    <td>
                                        <a href="#" @click="editModal(user)">
                                            <i class="fa fa-edit"></i
                                        ></a>
                                        |
                                        <a
                                            href="#"
                                            @click="deleteUser(user.id)"
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
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addNewLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-show="editMode"
                            class="modal-title"
                            id="addNewLabel"
                        >
                            Update User Info
                        </h5>
                        <h5
                            v-show="!editMode"
                            class="modal-title"
                            id="addNewLabel"
                        >
                            Add New User
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
                        @submit.prevent="editMode ? updateUser() : createUser()"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Full Name"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>
                            <!-- end of name field -->
                            <div class="form-group">
                                <input
                                    v-model="form.email"
                                    type="email"
                                    placeholder="E-mail"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('email')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="email"
                                ></has-error>
                            </div>
                            <!-- end of email field -->
                            <div class="form-group">
                                <input
                                    v-model="form.password"
                                    type="password"
                                    placeholder="Password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'password'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="password"
                                ></has-error>
                            </div>
                            <!-- end of password field -->
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="type"
                                    id="type"
                                    v-model="form.type"
                                    :class="{
                                        'is-invalid': form.errors.has('type')
                                    }"
                                >
                                    <option disabled selected value
                                        >-- Select User Type --</option
                                    >
                                    <option value="user">User</option>
                                    <option value="manager">Manager</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="type"
                                ></has-error>
                            </div>
                            <!-- end of type field -->
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
            form: new Form({
                id: "",
                name: "",
                email: "",
                type: "",
                password: ""
            })
        };
    },
    methods: {
        createModal() {
            this.form.reset();
            this.editMode = false;
            $("#addNew").modal("show");
        },
        editModal(user) {
            this.form.reset();
            this.editMode = true;
            this.form.fill(user);
            $("#addNew").modal("show");
        },
        updateUser() {
            this.$Progress.start();
            this.form
                .put("api/user/" + this.form.id)
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#addNew").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "User Updated Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    $("#addNew").modal("hide");
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
        createUser() {
            this.$Progress.start();
            this.form
                .post("api/user")
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#addNew").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "User Created Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    $("#addNew").modal("hide");
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });
        } /* end of createUser */,
        deleteUser(id) {
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
                        .delete("api/user/" + id)
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
        this.loadUsers();
        Fire.$on("UserAction", () => {
            this.loadUsers();
        });
    }
};
</script>
