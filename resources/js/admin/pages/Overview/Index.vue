<template>
    <div class="container-fluid">
        <div class="row">
            <!-- chart caard section start -->
            <div class="col-sm-6 col-xxl-3 col-lg-6">
                <div class="main-tiles border-5 border-0  card-hover card o-hidden">
                    <div class="custome-1-bg b-r-4 card-body">
                        <div class="media align-items-center static-top-widget">
                            <div class="media-body p-0">
                                <span class="m-0">Total Projects</span>
                                <h4 class="mb-0 counter">{{ total_cars }}
                                    <span class="badge badge-light-primary grow">
                                        <i data-feather="trending-up"></i>8.5%</span>
                                </h4>
                            </div>
                            <div class="align-self-center text-center">
                                <i class="ri-database-2-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xxl-3 col-lg-6">
                <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                    <div class="custome-2-bg b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="media-body p-0">
                                <span class="m-0">Total Customers</span>
                                <h4 class="mb-0 counter">{{ total_customers }}
                                    <span class="badge badge-light-danger grow">
                                        <i data-feather="trending-down"></i>{{ total_customers }}</span>
                                </h4>
                            </div>
                            <div class="align-self-center text-center">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xxl-3 col-lg-6">
                <div class="main-tiles border-5 card-hover border-0  card o-hidden">
                    <div class="custome-3-bg b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="media-body p-0">
                                <span class="m-0">Total Requests</span>
                                <h4 class="mb-0 counter">{{ total_requests }}
                                    <a href="#" class="badge badge-light-secondary grow">
                                        ADD NEW</a>
                                </h4>
                            </div>

                            <div class="align-self-center text-center">
                                <i class="ri-chat-3-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xxl-3 col-lg-6">
                <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                    <div class="custome-4-bg b-r-4 card-body">
                        <div class="media static-top-widget">
                            <div class="media-body p-0">
                                <span class="m-0">Total Orders</span>
                                <h4 class="mb-0 counter"> {{ total_orders }}
                                    <span class="badge badge-light-success grow">
                                        <i data-feather="trending-down"></i>8.5%</span>
                                </h4>
                            </div>

                            <div class="align-self-center text-center">
                                <i class="ri-user-add-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </div>


</template>

<script>
export default {
    mounted() {

        this.getCount();
    },
    data() {
        return {



            total_cars: 0,
            total_customers: 0,
            total_requests: 0,
            total_orders: 0,

        };
    },
    methods: {

        getCount() {


            axios
                .get("/api/admin/v1/admin/stats")
                .then(({ data }) => {
                    this.total_cars = data.data.total_cars ?? 0;
                    this.total_customers = data.data.total_customers ?? 0;
                    this.total_requests = data.data.total_requests ?? 0;
                    this.total_orders = data.data.total_orders ?? 0;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },



    },
};
</script>
