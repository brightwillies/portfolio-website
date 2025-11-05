<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="title-header option-title">
                            <h5>Admins Accounts</h5>

                            <button @click="showNewModal()" class="align-items-center btn btn-theme d-flex">
                                <i data-feather="plus-square"></i>Add New
                            </button>

                        </div>

                        <div class="table-responsive category-table">
                            <div>
                                <table class="table all-package theme-table" id="datatable">
                                    <thead>
                                        <tr>

                                            <th>Name</th>
                                            <th>Email</th>
                                            <th> Contact</th>
                                            <th>Status</th>
                                            <th>Added On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="item in tableData" :key="item.id">

                                            <td>{{ item.first_name }}
                                                {{ item.last_name }}
                                            </td>
                                            <td> {{ item.email }} </td>
                                            <td> {{ item.telephone_number }} </td>

                                            <td>{{ item.status_name }}</td>


                                            <td>{{ formatDate(item.created_at) }}</td>

                                            <td>
                                                <!-- <button  class="button"><i class="icon icon-heart  fs-13"></i></button> -->
                                                <button @click="launchEditModal(item)"
                                                    class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Save for Wishlist"> <i
                                                        class="ri-pencil-line"></i></button>
                                                <button @click="showDeleteModal(item)"
                                                    class="btn btn-square btn-danger-light me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"> <i
                                                        class="ri-delete-bin-line"></i></button>
                                            </td>


                                        </tr>
                                        <tr v-if="tableData.length === 0">
                                            <td colspan="11" class="text-center">No car requests found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="deleteRecordModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="mySmallModalLabel">
                            Deleting a record
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to remove
                            <strong> {{ selectedItem.first_name }} {{ selectedItem.last_name }}</strong> ?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            No
                        </button>
                        <button type="button" @click="deleteRecord" class="btn btn-primary">
                            Yes
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <!-- Add New Region Modal -->
        <div class="modal fade" id="newRecordModal">
            <div class="modal-dialog modal-md " role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">


                        <h6 v-show="!editmode" class="modal-title">Add New {{ item_name }}</h6>
                        <h6 v-show="editmode" class="modal-title">Update {{ item_name }}</h6>

                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form @submit.prevent="editmode ? updateRecord() : saveRecord()">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">first name</label>
                                        <input type="text" v-model="form.first_name" class="form-control"
                                            id="exampleInputEmail2">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Last name</label>
                                        <input type="text" v-model="form.last_name" class="form-control"
                                            id="exampleInputEmail2">
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-md-4 col-form-label">Select Role</label>

                                        <v-select id="sort_by_location" v-model="form.role_id" :options="roles"
                                            placeholder="Select Role" label="name" :reduce="name => name.id"></v-select>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Email</label>
                                        <input type="text" v-model="form.email" class="form-control"
                                            id="exampleInputEmail2">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Telephone Number</label>
                                        <input type="text" v-model="form.telephone_number" class="form-control"
                                            id="exampleInputEmail2">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Password</label>
                                        <input type="text" v-model="form.password" class="form-control"
                                            id="exampleInputEmail2">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword2">Status</label>

                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="rdiobox" for="rdio-primary-unchecked">
                                                    <input v-model="form.status" value="1" name="rdio-primary"
                                                        type="radio" class="radio-primary" id="rdio-primary-unchecked">
                                                    <span>Active</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="rdiobox" for="rdio-secondary-unchecked">
                                                    <input v-model="form.status" value="0" name="rdio-primary"
                                                        type="radio" class="radio-secondary"
                                                        id="rdio-secondary-unchecked">
                                                    <span>Inactive</span>
                                                </label>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>






                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">
                                <span v-show="!editmode">Submit Item</span>
                                <span v-show="editmode">Save Changes</span>
                            </button>

                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>





    </div>
</template>

<script>
import Form from "vform";

export default {
    components: {},
    data() {
        return {

            item_api: "/api/admin/v1/admin",
            item_name: "Administrator",

            imageAvatar: null,
            selectedItem: "",
            required: true,
            editmode: false,
            tableData: [],
            roles: [],
            form: new Form({
                first_name: "",
                last_name: "",
                email: "",
                telephone_number: "",
                role_id: "",
                region_id: "",
                password: "",
                mask: "",
                status: "",
                profile_image: ""
            }),
        };
    },
    mounted() {
        this.getRecords();
        this.getRoles();
    },
    methods: {

        saveRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("first_name", this.form.first_name);
            formData.append("last_name", this.form.last_name);
            formData.append("telephone_number", this.form.telephone_number);
            formData.append("role_id", this.form.role_id);
            formData.append("email", this.form.email);
            formData.append("status", this.form.status);

            formData.append("password", this.form.password);
            axios
                .post(this.item_api, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(
                    (response) => {
                        if (response) {
                            const res = response.data;

                            if (res.code === 200) {
                                this.successToastReloadPage(res.message);
                            } else {
                            }
                        }
                    },
                    function (error) {
                        if (error.response) {
                            console.log(error.response.data.errors);
                            error.response.data.errors.forEach((element) => {
                                vm.$toasted.show(element);
                            });
                            // alert(error.response.status);
                        }
                    }
                );
        },

        updateRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("first_name", this.form.first_name);
            formData.append("last_name", this.form.last_name);
            formData.append("telephone_number", this.form.telephone_number);
            formData.append("role_id", this.form.role_id);
            //   formData.append("region_id", this.form.region_id);
            formData.append("email", this.form.email);
            formData.append("password", this.form.password);
            formData.append("status", this.form.status);

            axios
                .post(this.item_api + "/" + this.form.mask, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(
                    (response) => {
                        if (response) {
                            const res = response.data;

                            if (res.code === 200) {
                                this.successToastReloadPage(res.message);
                            } else {
                            }
                        }
                    },
                    function (error) {
                        if (error.response) {
                            console.log(error.response.data.errors);
                            error.response.data.errors.forEach((element) => {
                                vm.$toasted.show(element);
                            });
                            // alert(error.response.status);
                        }
                    }
                );
        },

        showDeleteModal(record) {
            this.selectedItem = record;
            $("#deleteRecordModal").modal("show");
        },


        deleteRecord() {
            var vm = this;
            let formData = new FormData();

            axios
                .delete(this.item_api +
                    "/" + this.selectedItem.mask,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then(
                    (response) => {
                        if (response) {
                            const res = response.data;

                            if (res.code === 200) {
                                this.successToastReloadPage(res.message);
                            } else {
                            }
                        }
                    },
                    function (error) {
                        if (error.response) {
                            console.log(error.response.data.errors);
                            error.response.data.errors.forEach((element) => {
                                vm.$toasted.show(element);
                            });
                            // alert(error.response.status);
                        }
                    }
                );
        },
        initDatatable() {
            setTimeout(() => {
                $("#datatable").DataTable({
                    pagingType: "full_numbers",
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 100, "All"],
                    ],
                    order: [
                        [0, "asc"],
                        [8, "desc"],
                    ],
                    responsive: true,
                    destroy: true,
                    retrieve: true,
                    autoFill: true,
                    colReorder: true,
                });
            }, 300);
        },
        getRecords() {
            axios
                .get(this.item_api)
                .then(({ data }) => {
                    this.tableData = data.data;
                    this.initDatatable();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        getRoles() {
            axios
                .get("/api/admin/v1/role")
                .then(({ data }) => {
                    this.roles = data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        showNewModal() {
            this.editmode = false;
            $("#newRecordModal").modal("show");
        },
        showDeleteModal(record) {
            this.selectedItem = record;
            $("#deleteRecordModal").modal("show");
        },
        launchEditModal(record) {
            this.editmode = true;
            this.form.fill(record);
            $("#newRecordModal").modal("show");
        },
        formatDate(date) {
            if (!date) return 'Not specified';
            const d = new Date(date);
            return d.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
        },
        getStatusClass(status) {
            switch (status) {
                case 1:
                    return 'success';
                case 0:
                    return 'danger';
                default:
                    return 'secondary';
            }
        },
        getStatusText(status) {
            switch (status) {
                case 1:
                    return 'Active';
                case 0:
                    return 'Inactive';
                default:
                    return 'Unknown';
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
