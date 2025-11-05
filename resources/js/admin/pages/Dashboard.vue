<script>
import Footer from "./components/Footer"
import Sidebar from "./components/Sidebar"
import Headernav from "./components/Headernav"
// import Footer from "@/components/footer"
export default {
	components: { Footer, Sidebar, Headernav },	
	mounted() {
	},
	methods: {
		logout(e) {
			e.preventDefault();
			delete axios.defaults.headers.common["Authorization"];
			localStorage.removeItem("grocery_admin");
			localStorage.removeItem("grocery_admin_firstname");
			localStorage.removeItem("grocery_admin_pass");
			window.location.replace("/administrator-login");
		},
	}
}
</script>

<style lang="scss" scoped>

</style>

<template>
	<div>
		

		
		
		<!-- tap on top start -->
		<div class="tap-top">
			<span class="lnr lnr-chevron-up"></span>
		</div>
		<!-- tap on tap end -->
	
		<!-- page-wrapper Start-->
		<div class="page-wrapper compact-wrapper" id="pageWrapper">
			<!-- Page Header Start-->
			<Headernav />
			<!-- Page Header Ends-->
	
			<!-- Page Body Start-->
			<div class="page-body-wrapper">
				<!-- Page Sidebar Start-->
				
	
						<Sidebar />
						
					
				<!-- Page Sidebar Ends-->
	
				<!-- index body start -->
				<div class="page-body">
					<router-view></router-view>
					
					<!-- Container-fluid Ends-->
	
					<!-- footer start-->
					<footer/>
					<!-- footer End-->
				</div>
				<!-- index body end -->
	
			</div>
			<!-- Page Body End -->
		</div>
		<!-- page-wrapper End-->


		


		<div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="staticBackdropLabel">Logging Out</h5>
                    <p>Are you sure you want to log out?</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="button-box">
                        <button type="button" class="btn btn--no" data-bs-dismiss="modal">No</button>
                        <button type="button"  @click="logout" class="btn  btn--yes btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</div>
</template>

