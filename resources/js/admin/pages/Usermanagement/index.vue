<template>
	<div>
		<div class="page-header">
			<div>
				<h1 class="page-title">User management Settings</h1>
			</div>
			<div class="ms-auto pageheader-btn">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">Apps</li>
					<li class="breadcrumb-item active" aria-current="page">Settings</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-xl-3">
				<div class="card mb-4">
					<div class="card-body">
						<ul class="nav1 nav-column flex-column br-7 p-3">
						
						<li class="nav-item1">
								<router-link :to="{ name: 'superadmin'}"  class="nav-link thumb">
									<i class="ion-settings"></i>
									Super Administrators
								</router-link>
							</li>
							<li class="nav-item1">
								<router-link :to="{ name: 'admin'}"  class="nav-link thumb">
									<i class="ion-settings"></i>
								 Administrators
								</router-link>
							</li>
										
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-xl-9">
				<div class="row">
					<div class="col-xl-12 ">
						<div class="card">
							<router-view></router-view>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	setup() {
		return {}
	}
}
</script>

<style lang="scss" scoped>
.nav-item1 {

	border: 1px solid #8fbd56;
}

</style>