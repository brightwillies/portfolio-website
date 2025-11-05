<template>
    <div class="container-fluid">

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive category-table">
                        <div>
                            <table class="table all-package theme-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Featured</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in recentData" :key="item.id">
                                        <td>{{ item.name }}</td>

                                        <td>
                                            <div class="table-image">
                                                <img :src="item.image" class="img-fluid" alt="">
                                            </div>
                                        </td>
                                        <td>{{ item.category }}</td>
                                        <td>{{ item.featured_name }}</td>
                                        <td> {{ item.status_name }} </td>

                                        <td>
                                            <ul>

                                                <li>
                                                    <a :href="'/administrator-dashboard/product/' + item.mask">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
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
        <form @submit.prevent="editmode ? updateRecord() : saveRecord()" class="theme-form theme-form-2 mega-form">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">


                        <div class="title-header option-title">
                            <h5> <span v-show="!editmode"> Adding</span> <span v-show="editmode"> Updating</span> {{
                                item_name }} Information</h5>
                            <!-- <form class="d-inline-flex"> -->



                            <!-- </form> -->
                        </div>
                        <div class="card-body">


                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Model</label>
                                <div class="col-sm-9">
                                    <v-select v-model="form.model_id" :options="models" placeholder="Select Model"
                                        label="name" :reduce="name => name.id"></v-select>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Car Name</label>
                                <div class="col-sm-9">
                                    <input readonly v-model="form.title" class="form-control" type="text"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Car Name Details</label>
                                <div class="col-sm-9">
                                    <input v-model="form.name" class="form-control" type="text" placeholder="">
                                </div>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Mileage (km/h)</label>
                                <div class="col-sm-9">
                                    <input v-model="form.mileage" class="form-control" type="text" placeholder="">
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Fuel Type</label>
                                <div class="col-sm-9">
                                    <select v-model="form.fuel" class="js-example-basic-single w-100">
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Electri">Electric</option>

                                    </select>
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
                                <label class="col-sm-3 col-form-label form-label-title">Color</label>
                                <div class="col-sm-9">
                                    <v-select v-model="form.color_id" :options="colors" placeholder="Select Color"
                                        label="name" :reduce="color => color.id">
                                        <template #option="{ name, code }">
                                            <div class="color-option">
                                                <span class="color-swatch" :style="{ backgroundColor: code }"></span>
                                                {{ name }}
                                            </div>
                                        </template>
                                        <template #selected-option="{ name, code }">
                                            <div class="color-option">
                                                <span class="color-swatch" :style="{ backgroundColor: code }"></span>
                                                {{ name }}
                                            </div>
                                        </template>
                                    </v-select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="card">



                        <div class="card-body">
                            <div class="title-header option-title">
                                <h5> <span v-show="!editmode"> More</span> <span v-show="editmode"> More</span> {{
                                    item_name }} Information</h5>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Year</label>
                                <div class="col-sm-9">
                                    <input v-model="form.year" class="form-control" type="number" placeholder="">
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Transmision</label>
                                <div class="col-sm-9">
                                    <select v-model="form.transmission" class="js-example-basic-single w-100">
                                        <option value="Manual">Manual</option>
                                        <option value="Automatic">Automatic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Drive Type</label>
                                <div class="col-sm-9">
                                    <select v-model="form.drive_type" class="js-example-basic-single w-100">
                                        <option value="FWD">FWD</option>
                                        <option value="RWD">RWD</option>
                                        <option value="AWD">AWD</option>
                                        <option value="4WD">4WD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Condition</label>
                                <div class="col-sm-9">
                                    <select v-model="form.condition" class="js-example-basic-single w-100">
                                        <option value="New">New</option>
                                        <option value="Used">Used</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Engine Size (l)</label>
                                <div class="col-sm-9">
                                    <input v-model="form.engine_size" class="form-control" type="text" placeholder="">
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Price</label>
                                <div class="col-sm-9">
                                    <input v-model="form.price" class="form-control" type="text" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3"></div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 row align-items-center">
                                <label class="col-form-label form-label-title">Description</label>
                                <vue-editor v-model="form.description"></vue-editor>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4 row align-items-center">
                                    <!-- <label class="col-sm-3 col-form-label form-label-title">Prices</label> -->
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label class="col-md-2">Feature :</label>
                                        </div>
                                        <div style="margin-bottom:5px;" class="row" v-for="(input, k) in form.features"
                                            :key="k">
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" v-model="input.feature" />
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="col">
                                                        <i style="color: green" class="ri-pencil-line" @click="add(k)"
                                                            v-show="k == form.features.length - 1"></i>
                                                    </div>
                                                    <div class="col">
                                                        <i class="ri-delete-bin-line" @click="remove(k)" v-show="k || (!k && form.features.length > 1)
                                                            "></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">


                        <div class="card-body">



                            <div class="mb-4 row align-items-center">
                                <viewer class="row" :images="form.images">
                                    <div class="col-lg-4 col-md-4" v-for="src in form.images" :key="src.id">
                                        <img :src="src.image" class="previmg" />
                                        <span style="color: red" class="flaticon-delete-1"
                                            v-on:click="showRemovePreviewImageModal(src)"></span>
                                    </div>
                                </viewer>
                            </div>
                            <div class="mb-4 row align-items-center">

                                <div class="col-sm-12">
                                    <!-- <label class="col-form-label form-label-title">Category</label> -->
                                    <div id="designCard" class="card card-default">
                                        <label class="col-form-label form-label-title">Pictures</label>
                                        <!--Where we are uploaing the images -->
                                        <div class="card-body">
                                            <div id="my-strictly-unique-vue-upload-multiple-image"
                                                style="display: flex; justify-content: center"></div>

                                            <div class="mt-1 text-center">
                                                <div class="uploader" @dragenter="OnDragEnter" @dragleave="OnDragLeave"
                                                    @dragover.prevent @drop="onDrop" :class="{ dragging: isDragging }">
                                                    <div class="upload-control" v-show="images.length">
                                                        <label for="file">Select a file</label>
                                                    </div>

                                                    <div v-show="!images.length">
                                                        <i class="fa fa-cloud-upload"></i>
                                                        <p>Pleaase Drag your images here</p>
                                                        <div>OR</div>
                                                        <div class="file-input">
                                                            <label for="file">Select a file</label>
                                                            <input type="file" id="file" @change="onInputChange"
                                                                multiple />
                                                        </div>
                                                    </div>

                                                    <div class="images-preview" v-show="images.length">
                                                        <div class="img-wrapper" v-for="(image, index) in images"
                                                            :key="index">
                                                            <img :src="image" :alt="`Image Uplaoder ${index}`" />
                                                            <div class="details">
                                                                <span class="name" v-text="files[index].name"></span>
                                                                <span class="size"
                                                                    v-text="getFileSize(files[index].size)"></span>
                                                                <span style="color: red" class="flaticon-delete-1"
                                                                    v-on:click="removeImage(index)"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end of uploas -->
                                    </div>
                                </div>
                            </div>





                            <div class="mb-4 row align-items-center">
                                <div class="row">

                                    <div class="col-sm-12 offset-col-2">
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

                            <!-- </form> -->
                        </div>
                    </div>
                </div>



            </div>
        </form>
    </div>
</template>

<script>
import Form from "vform";

export default {
    components: {

    },
    data() {
        return {

            /**images keys */
            isDragging: false,
            dragCount: 0,
            images: [],
            files: [],
            /*end of image keys */


            item_api: "/api/admin/v1/car",
            item_name: "Car",



            selectedItem: "",
            required: true,
            editmode: false,
            tableData: [],
            recentData: [],
            models: [],
            colors: [],
            images: [],

            form: new Form({
                name: "",
                model_id: "",
                mileage: "",
                fuel: "",
                title: "",
                year: "",
                transmission: "",
                condition: "",
                drive_type:"",
                engine_size: "",
                color_id: "",
                price: "",
                mask: "",
                status: "",
                featured: "",
                description: "",
                price: "",
                name_details: "",
                images:[],
                features: [{
                    feature: "",
                },],




            }),
        };
    },
    mounted() {

        this.getRecent();
        this.getModels();
        this.getColors();

        if (this.$route.params.id) {
            this.getRecordDetails();
        }
    },

    watch: {
        // Watch for changes to form.model_id
        'form.model_id'(newModelId) {
            if (newModelId) {
                // Find the selected model in the models array
                const selectedModel = this.models.find(model => model.id === newModelId);
                if (selectedModel && selectedModel.title) {
                    // Update form.name with the model's title
                    this.form.title = selectedModel.title;
                } else {
                    this.form.title = selectedModel.name;
                    // Optionally, fetch the model details if title is not available
                    // this.fetchModelTitle(newModelId);
                }
            } else {
                // Clear form.name if no model is selected
                this.form.title = "";
            }
        }
    },

    methods: {

        add(index) {
            this.form.features.push({ feature: "" });
        },
        remove(index) {
            this.form.features.splice(index, 1);
        },


        async getFeaturedImage(e) {
            this.form.banner_image = this.$refs.bannerfile.files[0];
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

        getModels() {
            axios
                .get('/api/admin/v1/model')
                .then(({ data }) => {
                    this.models = data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getColors() {
            axios
                .get('/api/admin/v1/color')
                .then(({ data }) => {
                    this.colors = data.data;
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
                this.form.fill(data.data);
                this.editmode = true;
            });
        },

        updateRecord() {
            var vm = this;
            let formData = new FormData();
            formData.append("name", this.form.name);
            formData.append("title", this.form.title);
            formData.append("featured", this.form.featured);
            formData.append("description", this.form.description);
            formData.append("drive_type", this.form.drive_type);
            formData.append("model_id", this.form.model_id);
            formData.append("mileage", this.form.mileage);
            formData.append("fuel", this.form.fuel);
            formData.append("year", this.form.year);
            formData.append("transmission", this.form.transmission);
            formData.append("condition", this.form.condition);
            formData.append("engine_size", this.form.engine_size);
            formData.append("status", this.form.status);
            formData.append("price", this.form.price);
            formData.append("features", JSON.stringify(this.form.features));
            formData.append("color_id", this.form.color_id); // Add color_id
            this.files.forEach((file) => {
                formData.append("images[]", file, file.name);
            });

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
                                this.getRecent();
                            } else if (res.code === 422) {
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
                            } else {
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

            formData.append("name", this.form.name);
            formData.append("title", this.form.title);
            formData.append("featured", this.form.featured);
            formData.append("description", this.form.description);
            formData.append("drive_type", this.form.drive_type);
            formData.append("model_id", this.form.model_id);
            formData.append("mileage", this.form.mileage);
            formData.append("fuel", this.form.fuel);
            formData.append("year", this.form.year);
            formData.append("transmission", this.form.transmission);
            formData.append("condition", this.form.condition);
            formData.append("engine_size", this.form.engine_size);
            formData.append("status", this.form.status);
            formData.append("price", this.form.price);
            formData.append("features", JSON.stringify(this.form.features));
            formData.append("color_id", this.form.color_id); // Add color_id
            this.files.forEach((file) => {
                formData.append("images[]", file, file.name);
            });
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
                                this.successToastNoReload(res.message);
                                this.form.reset();
                                this.images = [];
                                this.getRecent();
                            } else { }
                        }
                    },
                    function (error) {
                        if (error.response) {

                            if (error.response.status != 400) {
                                console.log(error.response.data.message);
                                // vm.errorToastNoReload(error.response.data.message);
                                vm.$toasted.show(error.response.data.message);
                            } else {
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
                    formData, {
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
                            } else { }
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






        /* image upload methods*/
        removeImage(key) {
            this.images.splice(key, 1);
            this.files.splice(key, 1);
        },

        OnDragEnter(e) {
            e.preventDefault();

            this.dragCount++;
            this.isDragging = true;

            return false;
        },
        OnDragLeave(e) {
            e.preventDefault();
            this.dragCount--;

            if (this.dragCount <= 0) this.isDragging = false;
        },
        onInputChange(e) {
            const files = e.target.files;

            Array.from(files).forEach((file) => this.addImage(file));
        },
        onDrop(e) {
            e.preventDefault();
            e.stopPropagation();

            this.isDragging = false;

            const files = e.dataTransfer.files;

            Array.from(files).forEach((file) => this.addImage(file));
        },
        addImage(file) {
            if (!file.type.match("image.*")) {
                this.$toastr.e(`${file.name} is not an image`);
                return;
            }

            this.files.push(file);
            const img = new Image(),
                reader = new FileReader();
            reader.onload = (e) => this.images.push(e.target.result);
            reader.readAsDataURL(file);
        },

        getFileSize(size) {
            const fSExt = ["Bytes", "KB", "MB", "GB"];
            let i = 0;
            while (size > 900) {
                size /= 1024;
                i++;
            }
            return `${Math.round(size * 100) / 100} ${fSExt[i]}`;
        },
        /* end of images */
    },
};
</script>

<style lang="scss" scoped>
.previmg {
    padding-right: 2px;
    width: 100%;
    height: 200px;
    margin-top: 5px;
}

#designCard {
    padding: 5px !important;
}

// UPLOADER FORM
.uploader {
    width: 100%;
    background: #0da487;
    ;
    color: #fff;
    padding: 40px 15px;
    text-align: center;
    border-radius: 10px;
    border: 3px dashed #fff;
    font-size: 20px;
    position: relative;

    &.dragging {
        background: #fff;
        color: #0da487;
        ;
        border: 3px dashed #0da487;
        ;

        .file-input label {
            background: #0da487;
            ;
            color: #fff;
        }
    }

    i {
        font-size: 85px;
    }

    .file-input {
        width: 200px;
        margin: auto;
        height: 68px;
        position: relative;

        label,
        input {
            background: #fff;
            color: #0da487;
            ;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 7px;
            cursor: pointer;
        }

        input {
            opacity: 0;
            z-index: -2;
        }
    }

    .images-preview {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;

        .img-wrapper {
            width: 160px;
            display: flex;
            flex-direction: column;
            margin: 10px;
            height: 150px;
            justify-content: space-between;
            background: #fff;
            box-shadow: 5px 5px 20px #3e3737;

            img {
                max-height: 105px;
            }
        }

        .details {
            font-size: 12px;
            background: #fff;
            color: #000;
            display: flex;
            flex-direction: column;
            align-items: self-start;
            padding: 3px 6px;

            .name {
                overflow: hidden;
                height: 18px;
            }
        }
    }

    .upload-control {
        position: absolute;
        width: 100%;
        background: #fff;
        top: 0;
        left: 0;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        padding: 10px;
        padding-bottom: 4px;
        text-align: right;

        button,
        label {
            background: #0da487;
            ;
            border: 2px solid #03a9f4;
            border-radius: 3px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }

        label {
            padding: 2px 5px;
            margin-right: 10px;
        }
    }
}

// Color patch
.color-option {
    display: flex;
    align-items: center;
}

.color-swatch {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    border: 1px solid #ccc;
    display: inline-block;
}
</style>
