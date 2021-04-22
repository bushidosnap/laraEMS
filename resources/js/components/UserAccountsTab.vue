<template>
    <div>
        <form class="form-horizontal">
            <div class="form-row">
                <div class="form-group col">
                    <label class="col-sm-3 control-label">Full Name</label
                    ><!-- end of label name -->
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

                    <has-error :form="form" field="name"></has-error>
                </div>
                <!-- end of name field -->

                <div class="form-group col">
                    <label class="col-sm-3 control-label">E - mail</label
                    ><!-- end of label name -->
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

                    <has-error :form="form" field="email"></has-error>
                </div>
                <!-- end of email field -->
            </div>

            <a href="#" @click="changePasswordModal()">
                <i class="nav-icon fas fa-key color-red"></i>Change Password</a
            >

            <div class="form-group mt-2">
                <div class="col-sm-offset-2 col-sm-12">
                    <button
                        type="submit"
                        class="btn btn-success"
                        @click.prevent="updateUserInfo()"
                    >
                        Update</button
                    ><!-- end of update button -->
                </div>
            </div>
        </form>
        <!-- end of form -->
        <!-- PASSWORD MODAL -->
        <div
            class="modal fade"
            id="changePassword"
            tabindex="-1"
            role="dialog"
            aria-labelledby="changePasswordLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordLabel">
                            Change Password
                        </h5>
                    </div>
                    <!-- end of modal header -->
                    <form @submit.prevent="updatePassword()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="password" class=" control-label"
                                    >Old Password</label
                                >
                                <input
                                    type="password"
                                    v-model="form.oldPassword"
                                    name="oldPassword"
                                    id="oldPassword"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'oldPassword'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="oldPassword"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label"
                                    >New Password</label
                                >
                                <input
                                    type="password"
                                    v-model="form.newPassword"
                                    name="newPassword"
                                    id="newPpassword"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'newPassword'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="newPassword"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label"
                                    >Re-type New Password</label
                                >
                                <input
                                    type="password"
                                    v-model="form.rePassword"
                                    name="rePassword"
                                    id="rePassword"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'rePassword'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="rePassword"
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
                                Change Password
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
            form: new Form({
                id: "",
                name: "",
                email: "",
                password: "",
                oldPassword: "",
                newPassword: "",
                rePassword: ""
            })
        };
    },
    methods: {
        loadUsers() {
            axios.get("api/usershow").then(({ data }) => this.form.fill(data));
        },
        changePasswordModal() {
            $("#changePassword").modal("show");
        },
        updateUserInfo() {
            this.$Progress.start();
            this.form
                .patch("api/user/" + this.form.id)
                .then(() => {
                    Fire.$emit("UserAction");
                    swal.fire({
                        icon: "success",
                        title: "User Updated Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                    this.$Progress.fail();
                });
        },
        updatePassword() {
            this.$Progress.start();
            this.form
                .patch("api/user/" + this.form.id)
                .then(() => {
                    Fire.$emit("UserAction");
                    $("#changePassword").modal("hide");
                    swal.fire({
                        icon: "success",
                        title: "User Updated Successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                    this.$Progress.fail();
                });
        }
    },
    created() {
        this.loadUsers();
        Fire.$on("UserAction", () => {
            this.loadUsers();
        });
    }
};
</script>
