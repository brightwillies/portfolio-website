<template>
  <div>
    <div class="row row-sm">
      <div class="col-lg-12">
        <div class="card">
          <div>
            <div class="row mt-5">

              <div class="col-lg-8">
                <h3 style="padding-left:10px;" class="card-title">{{ item_name }}s</h3>
              </div>
              <div class="col-lg-4">
                <button @click="showNewModal()" class="btn btn-primary float-right"> Add New {{ item_name }}</button>
              </div>
            </div>

          </div>
          <div class="card-body">
            <div class="table-responsive export-table">
              <table id="datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                <thead>
                  <tr>
                    <th class="border-bottom-0">Name</th>
                    <th class="border-bottom-0">Contact</th>
                    <th class="border-bottom-0">Email</th>
                    <th class="border-bottom-0">Region</th>
                    <th class="border-bottom-0">Status</th>
                    <th class="border-bottom-0">Date Added</th>
                    <th class="border-bottom-0">Action</th>

                  </tr>
                </thead>
                <tbody>

                  <tr v-for="item in tableData" :key="item.id">

                    <td>{{ item.first_name }} {{ item.first_name }}</td>
                    <td>{{ item.telephone_number }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.region }}</td>
                    <td>{{ item.status_name }}</td>
                    <td>{{ item.registered_on }}</td>

                    <td>
                      <!-- <button  class="button"><i class="icon icon-heart  fs-13"></i></button> -->
                      <button @click="launchEditModal(item)" class="btn btn-square btn-info-light me-1"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i
                          class="icon icon-pencil  fs-13"></i></button>
                      <button class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Add New Region Modal -->
    <div class="modal fade" id="newRecordModal">
      <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">


            <h6 v-show="!editmode" class="modal-title">Add New {{ item_name }}</h6>
            <h6 v-show="editmode" class="modal-title">Update {{ item_name}}</h6>

            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                aria-hidden="true">&times;</span></button>
          </div>
          <form @submit.prevent="editmode ? updateRecord() : saveRecord()">
            <div class="modal-body">

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="exampleInputEmail2">first name</label>
                    <input type="text" v-model="form.first_name" class="form-control" id="exampleInputEmail2">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail2">Last name</label>
                    <input type="text" v-model="form.last_name" class="form-control" id="exampleInputEmail2">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail2">Email</label>
                    <input type="text" v-model="form.email" class="form-control" id="exampleInputEmail2">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail2">Telephone Number</label>
                    <input type="text" v-model="form.telephone_number" class="form-control" id="exampleInputEmail2">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail2">Password</label>
                    <input type="text" v-model="form.password" class="form-control" id="exampleInputEmail2">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword2">Staff ID</label>
                    <input v-model="form.staff_id" type="text" class="form-control" id="exampleInputPassword2">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword2">Region</label>
                    <v-select v-model="form.region_id" :options="regions" placeholder="Select Region" label="name"
                      :reduce="name => name.id"></v-select>

                    <!-- <multiselect v-model="form.region_id" :options="regions" value="id"   :multiple="false" placeholder="Select one" label="name" track-by="option.id"></multiselect> -->
                  </div>

                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="exampleInputPassword2">Status</label>

                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <label class="rdiobox" for="rdio-primary-unchecked">
                          <input v-model="form.status" value="1" name="rdio-primary" type="radio" class="radio-primary"
                            id="rdio-primary-unchecked">
                          <span>Active</span>
                        </label>
                      </div>
                      <div class="col-lg-6 col-sm-12">
                        <label class="rdiobox" for="rdio-secondary-unchecked">
                          <input v-model="form.status" value="0" name="rdio-primary" type="radio"
                            class="radio-secondary" id="rdio-secondary-unchecked">
                          <span>Inactive</span>
                        </label>
                      </div>



                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword2" class="form-control-label">Profile
                      Picture</label>
                    <img :src="imageAvatar" id="profile-img-tag" style="padding:24px; border-radius:5%;" height="300px" width="100%" />
                  </div>

                  <div class="form-group">
                    <!-- <label for="formFile" class="form-label">Default file input example</label> -->
                    <input @change="
                      getFeaturedImage
                    " ref="webfile" class="form-control file-input" type="file" id="formFile">
                  </div>
                </div>
              </div>
              <!-- <div class="form-group">
                <v-select id="sort_by_location" v-model="form.country_id" :options="countries"
                  placeholder="Select Country" label="name" :reduce="(name) => name.id"></v-select>
              </div> -->





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

    <!--end of new region modal-->
  </div>
</template>

<script>

// import "jquery/dist/jquery.min.js";
// import "bootstrap/dist/css/bootstrap.min.css";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import Form from "vform";
//  import $ from "jquery";
export default {
  components: {

  },
  data() {
    return {

      item_api: "/api/sadmin/v1/user-settings/superadmin",
      item_name: "Super Administrator",


      imageAvatar: null,

      selectedItem: "",
      required: true,
      editmode: false,
      tableData: [],
      regions: [],
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
    this.getRegions();
    //    alert('Bright');
  },

  methods: {
    getRegions() {
      axios
        .get("/api/sadmin/v1/settings/region")
        .then(({ data }) => {
          this.regions = data.data;
        })
        .catch(function (error) {
          console.log(error);
        });

    },

    modalClose() {
      $("#newRecordModal").modal("hide");
    },
    DeleteModalClose() {
      $("#deleteRecordModal").modal("hide");
    },
    async getFeaturedImage(e) {
      this.form.profile_image = this.$refs.webfile.files[0];
      let image = e.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.imageAvatar = e.target.result;
      };
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
          //   setTimeout(() => {
          //     $("#datatable").DataTable({
          //       lengthMenu: [
          //         [5, 10, 25, 50, -1],
          //         [5, 10, 25, 50, "All"],
          //       ],
          //       pageLength: 5,
          //     });
          //   });
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    updateRecord() {
      var vm = this;
      let formData = new FormData();
      formData.append("first_name", this.form.first_name);
      formData.append("last_name", this.form.last_name);
      formData.append("telephone_number", this.form.telephone_number);
      formData.append("role_id", this.form.role_id);
      formData.append("region_id", this.form.region_id);
      formData.append("email", this.form.email);
      formData.append("password", this.form.password);
      formData.append("status", this.form.status);
      formData.append("profile_image", this.form.profile_image);
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
      formData.append("first_name", this.form.first_name);
      formData.append("last_name", this.form.last_name);
      formData.append("telephone_number", this.form.telephone_number);
      formData.append("role_id", this.form.role_id);
      formData.append("region_id", this.form.region_id);
      formData.append("email", this.form.email);
      formData.append("status", this.form.status);
      formData.append("profile_image", this.form.profile_image);
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
<style src="vue-multiselect/dist/vue-multiselect.min.css">

</style>
<style lang="scss" scoped>
.dataTables_length {
  float: none !important;
}
</style>
