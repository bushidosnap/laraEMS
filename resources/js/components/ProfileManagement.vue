<template>
    <div class="container">
        <div v-if="!$gate.isAdminManager()">
            <notFound></notFound>
        </div>
        <div class="row mt-5" v-if="$gate.isAdminManager()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profile Management</h3>
                        <div class="card-tools"></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="profile in profiles"
                                    :key="profile.id"
                                >
                                    <td>{{ profile.user_id }}</td>
                                    <td>{{ profile.gender | upFirstWord }}</td>
                                    <td>
                                        {{ profile.date_of_birth | customDate }}
                                    </td>
                                    <td>{{ profile.address }}</td>
                                    <td>{{ profile.contact }}</td>
                                    <td>
                                        <a href="#" @click="editModal(profile)">
                                            <i class="fa fa-edit"></i>Edit</a
                                        >
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
                        <h5 class="modal-title" id="addNewLabel">
                            Update Profile Info
                        </h5>
                    </div>
                    <!-- end of modal header -->
                    <form @submit.prevent="updateProfile()">
                        <div class="modal-body">
                            <div class="form-group">
                                <select
                                    class="form-control"
                                    name="gender"
                                    id="gender"
                                    v-model="form.gender"
                                    :class="{
                                        'is-invalid': form.errors.has('gender')
                                    }"
                                >
                                    <option disabled selected value
                                        >-- Select Gender --</option
                                    >
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="gender"
                                ></has-error>
                            </div>
                            <!-- end of gender field -->
                            <div class="form-group">
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
                                        >-- Select Civil Status --</option
                                    >
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="seperated">Seperated</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="civil_status"
                                ></has-error>
                            </div>
                            <!-- end of civil_status field -->
                            <div class="form-group">
                                <input
                                    v-model="form.address"
                                    type="text"
                                    placeholder="Residential Address"
                                    name="address"
                                    id="address"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('address')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="address"
                                ></has-error>
                            </div>
                            <!-- end of address field -->
                            <div class="form-group">
                                <input
                                    v-model="form.contact"
                                    type="text"
                                    placeholder="Mobile Number/Telephone Number"
                                    name="contact"
                                    id="contact"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('contact')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="contact"
                                ></has-error>
                            </div>
                            <!-- end of contact field -->
                            <div class="form-group">
                                <input
                                    v-model="form.bio"
                                    type="text"
                                    placeholder="Biography"
                                    name="bio"
                                    id="bio"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('bio')
                                    }"
                                />
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <!-- end of bio field -->
                            <div class="form-group">
                                <input
                                    v-model="form.skills"
                                    type="text"
                                    placeholder="Skills"
                                    name="skills"
                                    id="skills"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('skills')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="skills"
                                ></has-error>
                            </div>
                            <!-- end of skills field -->
                            <div class="form-group">
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
    <!-- end of container -->
</template>
<script>
export default {
    data() {
        return {
            editMode: true,
            profiles: {},
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
        loadProfiles() {
            axios.get("api/profile").then(({ data }) => {
                this.profiles = data.data;
            });
        },
        editModal(profile) {
            this.form.reset();
            this.form.fill(profile);
            $("#addNew").modal("show");
        },
        updateProfile() {
            this.$Progress.start();
            this.form
                .put("api/profile/" + this.form.user_id)
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
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                });
        }
    } /* end of methods */,
    created() {
        this.loadProfiles();
        Fire.$on("UserAction", () => {
            this.loadProfiles();
        });
    }
};
</script>
