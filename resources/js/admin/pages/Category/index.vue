<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="title-header option-title">
                            <h5>All Projects</h5>
                            <form class="d-inline-flex">

                                <a href="/administrator-dashboard/category" class="align-items-center btn btn-theme d-flex">
                                    <i data-feather="plus-square"></i>Add New
                                </a>

                            </form>
                        </div>

                        <div class="table-responsive category-table">
                            <div>
                                <table class="table all-package theme-table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Notebook Link</th>
                                            <!-- <th>Meta Description</th> -->
                                            <!-- <th>Meta Keyword</th> -->
                                            <th>Image</th>

                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="item in tableData" :key="item.id">
                                            <td>{{ item.title }}</td>
                                            <td>{{ item.notebook }}</td>
                                            <td>
                                                <div class="table-image">
                                                    <img :src="item.image" class="img-fluid" alt="">
                                                </div>
                                            </td>

                                            <td>
                                                <ul>
                                                    <!-- <li>
                                                        <a href="order-detail.html">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li> -->

                                                    <li>
                                                        <a :href=" '/administrator-dashboard/project/' + item.mask">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>

                                                    <li>
                                                          <button class="btn" type="button" @click="showDeleteModal(item)">
                                                            <i class="ri-delete-bin-line"></i>
                                                     </button>

                                                        <!-- <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalToggle">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a> -->
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



           <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteRecordModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Deleting a Project</h5>
                        <button type="button" class="btn-close" @click="DeleteModalClose()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to remove project  with title (<strong>{{ selectedItem.title }}  ?</strong>)?
                        </p>

                        <img width="100%"  :src="selectedItem.image" alt="">
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
// import "datatables.net-dt/js/dataTables.dataTables";
// import "datatables.net-dt/css/jquery.dataTables.min.css";
//   import $ from "jquery";
export default {
    components: {

    },
    data() {
        return {

            item_api: "/api/admin/v1/category",
            item_name: "Project",

            imageAvatar: null,

            selectedItem: "",
            required: true,
            editmode: false,
            tableData: [],
        };
    },
    mounted() {
        this.getRecords();

        //    alert('Bright');
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

        
         showNewModal() {
            this.form.reset();
            this.editmode = false;
            const modal = new bootstrap.Modal(document.getElementById('newRecordModal'));
            modal.show();
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

                    // this.initDatatable();
                      setTimeout(() => {
                        $("#datatable").DataTable({
                          lengthMenu: [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"],
                          ],
                          pageLength: 5,
                        });
                      });
                })
                .catch(function (error) {
                    console.log(error);
                });
        },


        showNewModal() {
            // this.form.reset();
            this.editmode = false;
            $("#newRecordModal").modal("show");
        },
        showDeleteModal(record) {
            this.selectedItem = record;
            $("#deleteRecordModal").modal("show");
        },

        launchEditModal(record) {
            this.form.reset();
            this.editmode = true;
            this.form.fill(record);
            this.imageAvatar = record.image;
            $("#newRecordModal").modal("show");
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

</style>
