<template>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div
                        class="widget-user-header bg-black"
                        style="background: url('/storage/img/home_office.jpg') center center;"
                    >
                        <h3 class="widget-user-username">
                            {{ this.users.name }}
                        </h3>
                        <h5 class="widget-user-desc">
                            {{ this.form.bio }}
                        </h5>
                    </div>
                    <div class="widget-user-image">
                        <img
                            class="img-circle"
                            :src="getProfileImage()"
                            alt="User Avatar"
                        />
                        <a href="#" @click="changePhoto()"
                            ><i
                                class="nav-icon fas fa-camera color-black align-bottom"
                            ></i
                        ></a>
                    </div>
                    <div class="box-footer mt-5">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">300</h5>
                                    <span class="description-text">MAIL</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13</h5>
                                    <span class="description-text">TASK</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text"
                                        >NOTIFICATIONS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a
                                    class="nav-link active show"
                                    href="#activity"
                                    data-toggle="tab"
                                    >Activity</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    href="#settings"
                                    data-toggle="tab"
                                    >Profile Settings</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    href="#accounts"
                                    data-toggle="tab"
                                    >User Accounts</a
                                >
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Activity Tab -->
                            <div class="tab-pane active show" id="activity">
                                <h3 class="text-center">
                                    Display User Activity
                                </h3>
                            </div>

                            <!-- Setting Tab -->
                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label
                                                for="inputGender"
                                                class="col-sm-2 control-label"
                                                >Gender</label
                                            ><!-- end of label gender -->
                                            <select
                                                class="form-control"
                                                name="gender"
                                                id="gender"
                                                v-model="form.gender"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'gender'
                                                    )
                                                }"
                                            >
                                                <option disabled selected value
                                                    >-- Select Gender --</option
                                                >
                                                <option value="male"
                                                    >Male</option
                                                >
                                                <option value="female"
                                                    >Female</option
                                                >
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="gender"
                                            ></has-error>
                                        </div>
                                        <!-- end of gender field -->
                                        <div class="form-group col">
                                            <label
                                                class="col-sm-3 control-label"
                                                >Civil Status</label
                                            ><!-- end of label Civil Status -->
                                            <select
                                                class="form-control"
                                                name="civil_status"
                                                id="civil_status"
                                                v-model="form.civil_status"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'civil_status'
                                                    )
                                                }"
                                            >
                                                <option disabled selected value
                                                    >-- Select Civil Status
                                                    --</option
                                                >
                                                <option value="single"
                                                    >Single</option
                                                >
                                                <option value="married"
                                                    >Married</option
                                                >
                                                <option value="seperated"
                                                    >Seperated</option
                                                >
                                            </select>
                                            <has-error
                                                :form="form"
                                                field="civil_status"
                                            ></has-error>
                                        </div>
                                        <!-- end of civil_status field -->
                                    </div>
                                    <!-- end of form-row -->
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label
                                                for="inputContact"
                                                class="col-sm-3 control-label"
                                                >Mobile No.</label
                                            ><!-- end of label contact -->
                                            <input
                                                v-model="form.contact"
                                                type="text"
                                                placeholder="Mobile Number/Telephone Number"
                                                name="contact"
                                                id="contact"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'contact'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="contact"
                                            ></has-error>
                                        </div>
                                        <!-- end of contact field -->
                                        <div class="form-group col">
                                            <label
                                                for="inputSkills"
                                                class="col-sm-2 control-label"
                                                >Skills</label
                                            ><!-- end of label skills -->
                                            <input
                                                v-model="form.skills"
                                                type="text"
                                                placeholder="Skills"
                                                name="skills"
                                                id="skills"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'skills'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="skills"
                                            ></has-error>
                                        </div>
                                        <!-- end of skills field -->
                                    </div>
                                    <!-- end of form-row -->
                                    <div class="form-group">
                                        <label
                                            for="inputAddress"
                                            class="col-sm-2 control-label"
                                            >Residential Address</label
                                        ><!-- end of label address -->
                                        <input
                                            v-model="form.address"
                                            type="text"
                                            placeholder="Residential Address"
                                            name="address"
                                            id="address"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'address'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="address"
                                        ></has-error>
                                    </div>
                                    <!-- end of address field -->

                                    <div class="form-group">
                                        <label
                                            for="inputBio"
                                            class="col-sm-2 control-label"
                                            >Shout Out</label
                                        ><!-- end of label bio -->
                                        <input
                                            v-model="form.bio"
                                            type="text"
                                            placeholder="Biography"
                                            name="bio"
                                            id="bio"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'bio'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="bio"
                                        ></has-error>
                                    </div>
                                    <!-- end of bio field -->
                                    <div class="form-group">
                                        <label
                                            for="inputdateofbirth"
                                            class="col-sm-2 control-label"
                                            >Date of Birth</label
                                        ><!-- end of label data_of_birth -->
                                        <div class="input-group">
                                            <input
                                                type="date"
                                                v-model="form.date_of_birth"
                                                name="date_of_birth"
                                                id="date_of_birth"
                                                class="form-control"
                                                data-inputmask="'alias': 'mm/dd/yyyy'"
                                                data-mask=""
                                                :class="{
                                                    'is-invalid': form.errors.has(
                                                        'date_of_birth'
                                                    )
                                                }"
                                            />
                                            <has-error
                                                :form="form"
                                                field="date_of_birth"
                                            >
                                            </has-error>
                                        </div>
                                    </div>
                                    <!-- end of date of birth -->

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                            <button
                                                type="submit"
                                                class="btn btn-success"
                                                @click.prevent="
                                                    updateProfileInfo()
                                                "
                                            >
                                                Update</button
                                            ><!-- end of update button -->
                                        </div>
                                    </div>
                                </form>
                                <!-- end of form -->
                            </div>
                            <div class="tab-pane" id="accounts">
                                <UserAccountsTab></UserAccountsTab>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
        <!-- /.row -->
        <div
            class="modal fade"
            id="photo"
            tabindex="-1"
            role="dialog"
            aria-labelledby="photoLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoLabel">
                            Change Profile Photo
                        </h5>
                    </div>
                    <!-- end of modal header -->
                    <form @submit.prevent="updatePhoto()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label
                                    for="image"
                                    class="col-sm-3 control-label"
                                    >Profile Photo</label
                                >
                                <div class="col-sm-12">
                                    <input
                                        type="file"
                                        @change="changeProfileTrigger"
                                        name="image"
                                        id="image"
                                        class="form-input"
                                    />
                                </div>
                                <has-error
                                    :form="form"
                                    field="image"
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
                                Update
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
            users: {},
            form: new Form({
                user_id: "",
                gender: "",
                civil_status: "",
                address: "",
                contact: "",
                bio: "",
                skills: "",
                date_of_birth: "",
                image: ""
            })
        };
    },
    methods: {
        loadUsers() {
            axios
                .get("api/profileshow")
                .then(({ data }) => this.form.fill(data));
            axios
                .get("api/usershow")
                .then(response => {
                    this.users = response.data;
                })
                .catch(e => {
                    this.errors.push(e);
                });
        },
        updateProfileInfo() {
            this.$Progress.start();
            this.form
                .put("api/profile/" + this.form.user_id)
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
        changePassword() {
            $("#changePassword").modal("show");
        },
        getProfileImage() {
            let image = "/storage/profilePhoto/" + this.form.image;
            return image;
        },
        changePhoto() {
            $("#photo").modal("show");
        },
        changeProfileTrigger(e) {
            let file = e.target.files[0];
            if (file["size"] < 2000000) {
                let reader = new FileReader();
                reader.onloadend = file => {
                    this.form.image = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                swal.fire(
                    "Error!",
                    "You are uploading more than 5MB.",
                    "warning"
                );
            }
        },
        updatePhoto() {
            this.form
                .put("api/updatePhoto")
                .then(() => {
                    Fire.$emit("UserAction");
                    swal.fire({
                        icon: "success",
                        title: "User Updated Successfully"
                    });
                    $("#photo").modal("hide");
                })
                .catch(() => {
                    swal.fire(
                        "Failed!",
                        "There was something wrong.",
                        "warning"
                    );
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
