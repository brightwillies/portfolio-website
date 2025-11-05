<template>
    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-10">
                <div class="card">

                    <div class="title-header option-title">
                        <h5> <span v-show="!editmode"> Adding</span> <span v-show="editmode"> Updating</span> {{
                            item_name
                            }} Information</h5>
                        <form class="d-inline-flex">

                            <a href="/administrator-dashboard/projects"
                                class="align-items-center btn btn-theme d-flex">
                                <i data-feather="plus-square"></i>View List
                            </a>

                        </form>
                    </div>

                    <div class="card-body">
                        <!-- <div class="card-header-2">
                                    <h5>Category Information</h5>
                                </div> -->

                        <form @submit.prevent="editmode ? updateRecord() : saveRecord()"
                            class="theme-form theme-form-2 mega-form">

                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Project Title</label>
                                <div class="col-sm-9">
                                    <input v-model="form.title" class="form-control" type="text" placeholder="">
                                </div>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Status</label>
                                <div class="col-sm-9">
                                    <select v-model="form.status" class="js-example-basic-single w-100">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Banner
                                </label>
                                <div class="form-group col-sm-9">
                                    <img :src="bannerAvatar" id="profile-img-tag" height="200px" width="30%" />
                                    <input @change="
                                        getFeaturedImage
                                    " ref="bannerfile" class="form-control form-choose" type="file"
                                        id="formFileMultiple" multiple="">
                                </div>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="col-form-label form-label-title">Description</label>
                                <vue-editor v-model="form.description"></vue-editor>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Notebook Link</label>
                                <div class="col-sm-9">
                                    <input v-model="form.notebook" class="form-control" type="text" placeholder="">
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-sm-9">
                                        <button class="align-items-center btn btn-theme d-flex" style="width:100%">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-plus-square">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                                <line x1="8" y1="12" x2="16" y2="12"></line>
                                            </svg>
                                            <span v-show="!editmode"> Add New {{ item_name }}</span>
                                            <span v-show="editmode"> Update {{ item_name }}</span>

                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>



        </div>

    </div>
</template>

<script>
import Form from "vform";

export default {
    components: {

    },
    data() {
        return {

            item_api: "/api/admin/v1/category",
            item_name: "Project",


            webAvatar: null,
            mobileAvatar: null,
            bannerAvatar: null,

            selectedItem: "",
            required: true,
            editmode: false,
            tableData: [],
            recentData: [],
            regions: [],
            form: new Form({
                title: "",
                noteboook: "",
                mask: "",
                description: "",
                notebook:"",
                status: "0",
                image: ""

            }),
        };
    },
    mounted() {
        this.getRecords();
        // this.getRecent();

        if (this.$route.params.id) {
            this.getRecordDetails();
        }
        //    alert('Bright');
    },

    methods: {

        modalClose() {
            $("#newRecordModal").modal("hide");
        },
        DeleteModalClose() {
            $("#deleteRecordModal").modal("hide");
        },

        async getFeaturedImage(e) {
            this.form.image = this.$refs.bannerfile.files[0];
            let image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = (e) => {
                this.bannerAvatar = e.target.result;
            };
        },


        setFeatureStatus() {
            this.form.featured_name = !this.featured_name;
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

                    this.initDatatable();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getRecent() {


            axios
                .get(this.item_api + '/recent/recent')
                .then(({ data }) => {
                    this.recentData = data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },


        getRecordDetails() {
            let mask = this.$route.params.id;
            axios.get(this.item_api + "/" + mask).then(({ data }) => {
                this.bannerAvatar = data.data.image;
                this.form.fill(data.data);
                this.editmode = true;
            });
        },

        updateRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);
            formData.append("notebook", this.form.notebook);
            formData.append("status", this.form.status);
            formData.append("image", this.form.image);

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
                            }
                            else if (res.code === 422) {
                                alert('bee');
                            }
                        }
                    },
                    function (error) {
                        if (error.response) {

                            if (error.response.status != 400) {
                                console.log(error.response.data.message);
                                // vm.errorToastNoReload(error.response.data.message);
                                vm.$toasted.show(error.response.data.message);
                            }
                            else {
                                error.response.data.errors.forEach((element) => {
                                    vm.$toasted.show(element);
                                });
                            }
                        }
                    }
                );
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
        saveRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);
            formData.append("notebook", this.form.notebook);
            formData.append("status", this.form.status);
            formData.append("image", this.form.image);
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

                            if (error.response.status != 400) {
                                console.log(error.response.data.message);
                                // vm.errorToastNoReload(error.response.data.message);
                                vm.$toasted.show(error.response.data.message);
                            }
                            else {
                                error.response.data.errors.forEach((element) => {
                                    vm.$toasted.show(element);
                                });
                            }
                        }
                    }
                );
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
    },
};
</script>

<style lang="scss" scoped>
#profile-img-tag {

    padding-top: 24px;
    padding-right: 24px;
    padding-bottom: 24px;
    border-radius: 5%;
}
</style>
