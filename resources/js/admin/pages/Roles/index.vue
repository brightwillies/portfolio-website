<template>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">System Roles</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-9"></div>
            <div class="col-lg-3 align-self-center">
                <button class="btn btn-primary btn-block mb-3" @click="showNewModal">
                    Add New Role
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                           <div class="table-responsive category-table">

                              <table class="table all-package theme-table" id="datatable">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Number of Users</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="singleItem in tableData" :key="singleItem.id">
                                        <td>{{ singleItem.name }}</td>
                                        <td>{{ singleItem.description }}</td>
                                        <td>{{ singleItem.status_name }}</td>
                                        <td>{{ singleItem.total }}</td>
                                        <td>
                                            <button class="btn" type="button" @click="launchEditModal(singleItem)">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn" type="button" @click="showDeleteModal(singleItem)">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Role Modal -->
        <div class="modal fade" id="newRecordModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roleModalLabel">
                            <span v-show="!editmode">Add Role Details</span>
                            <span v-show="editmode">Update Role Details</span>
                        </h5>
                        <button type="button" class="btn-close" @click="modalClose()" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="editmode ? updateRecord() : saveRecord()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-4 row align-items-center">
                                                <label class="form-label-title col-sm-3 mb-0">Name</label>
                                                <div class="col-sm-12">
                                                    <input required v-model="form.name" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="form-label-title col-sm-5 mb-0">Description</label>
                                                <div class="col-sm-12">
                                                    <input required v-model="form.description" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-4 col-form-label form-label-title">Status</label>
                                                <div class="col-sm-12">
                                                    <select v-model="form.status" class="form-select">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="title-header option-title">
                                                <h5>Choose Permissions</h5>
                                            </div>
                                            <div class="row">
                                                <div v-for="per in permissions" :key="per.id" class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               :value="per.value"
                                                               v-model="form.selectedpermissions"
                                                               :id="'permission_' + per.id" />
                                                        <label class="form-check-label" :for="'permission_' + per.id">
                                                            {{ per.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <span v-show="!editmode">Add New Role</span>
                                        <span v-show="editmode">Update Role Details</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteRecordModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Deleting a record</h5>
                        <button type="button" class="btn-close" @click="DeleteModalClose()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to remove role (<strong>{{ selectedItem.name }}</strong>)?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="DeleteModalClose()">No</button>
                        <button type="button" class="btn btn-primary" @click="deleteRecord">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from "vform";

export default {

    data() {
        return {
            item_api: "/api/admin/v1/role",
            item_name: "Role",

            selectedItem: "",
            editmode: false,
            tableData: [],



            permissions: [
                { id: 2, name: "Cars Page", value: "perm_cars_page" },
                { id: 2, name: "Category Page", value: "perm_category_page" },
                { id: 3, name: "Car Make Page", value: "perm_maker_page" },
                { id: 3, name: "Car Model Page", value: "perm_model_page" },
                { id: 4, name: "Car Requests", value: "perm_car_request" },
                { id: 5, name: "Car Quotes", value: "perm_car_quotes" },
                { id: 5, name: "Orders", value: "perm_orders" },
                { id: 6, name: "Admin Page", value: "perm_admin" },
                { id: 6, name: "Roles Page", value: "perm_roles" },
                { id: 6, name: "Create Invoice Page", value: "perm_invoice_create" },
                { id: 6, name: "view Invoice Page", value: "perm_invoice_view" },
            ],

            form: new Form({
                name: "",
                description: "",
                selectedpermissions: [],
                status: "1",
                mask: "",
            }),
        };
    },
    mounted() {
        this.getRecords();
    },

    methods: {
        modalClose() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('newRecordModal'));
            modal.hide();
        },

        DeleteModalClose() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteRecordModal'));
            modal.hide();
        },

        initDatatable() {
            setTimeout(() => {
                $(".table").DataTable({
                    pagingType: "full_numbers",
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 100, "All"],
                    ],
                    order: [
                        [0, "asc"],
                        [3, "desc"],
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

        updateRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("name", this.form.name);
            formData.append("description", this.form.description);
            formData.append("status", this.form.status);
            formData.append("permissions", this.form.selectedpermissions);

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
                        }
                    }
                );
        },

        showNewModal() {
            this.form.reset();
            this.editmode = false;
            const modal = new bootstrap.Modal(document.getElementById('newRecordModal'));
            modal.show();
        },

        showDeleteModal(record) {
            this.selectedItem = record;
            const modal = new bootstrap.Modal(document.getElementById('deleteRecordModal'));
            modal.show();
        },

        launchEditModal(record) {
            this.form.reset();
            this.editmode = true;
            this.form.fill(record);
            // Make sure to set selected permissions when editing
            if (record.permissions) {
                this.form.selectedpermissions = record.permissions;
            }
            const modal = new bootstrap.Modal(document.getElementById('newRecordModal'));
            modal.show();
        },

        saveRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("name", this.form.name);
            formData.append("description", this.form.description);
            formData.append("status", this.form.status);
            formData.append("permissions", this.form.selectedpermissions);

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
                        }
                    }
                );
        },

        deleteRecord() {
            var vm = this;
            let formData = new FormData();

            axios
                .delete(this.item_api + "/" + this.selectedItem.mask, formData, {
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
                        }
                    }
                );
        },
    },
};
</script>

<style lang="scss" scoped>
.table-responsive {
    margin-bottom: 0;
}

.btn {
    i {
        font-size: 16px;
    }
}

.modal-header {
    .btn-close {
        background: transparent;
        border: none;
        font-size: 1.5rem;
    }
}

.form-check {
    margin-bottom: 10px;
}

.form-check-input {
    margin-right: 8px;
}
</style>
