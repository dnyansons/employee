<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid"> 
			<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
				<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
					<!--begin::Info-->
					<div class="d-flex align-items-center flex-wrap mr-1">
						<!--begin::Page Heading-->
						<div class="d-flex align-items-baseline mr-5">
							<!--begin::Page Title-->
							<h5 class="text-dark font-weight-bold my-2 mr-5">Edit Employee</h5>
							<!--end::Page Title-->
							<!--begin::Breadcrumb-->

							<!--end::Breadcrumb-->
						</div>
						<!--end::Page Heading-->
					</div>
					<!--end::Info-->

				</div>
			</div>
			<div class="d-flex flex-column-fluid">
				<!--begin::Container-->
				<div class="container">

					<!--begin::Card-->
					<div class="card card-custom example example-compact">


						<!--begin::Form-->
						<form class="form" method="post"  enctype="multipart/form-data">
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">

										<div class="form-group">


											<label class="  col-form-label">Name</label>
											<input class="form-control" type="text" name="name" value="<?php echo $users->name; ?>">
											<?php echo form_error("name"); ?>
											<input type="hidden" name="id" value="<?php echo $employee_id; ?>">

										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">


											<label class="col-form-label">Address</label>
											<input class="form-control" type="text" name="address" value="<?php echo $users->address; ?>">
											<?php echo form_error("address"); ?>

										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">


											<label class="  col-form-label">Mobile</label>
											<input class="form-control" type="text" name="mobile" value="<?php echo $users->mobile; ?>">

											<?php echo form_error("mobile"); ?>

										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">


											<label class="  col-form-label">Email</label>
											<input class="form-control" type="text" name="email" value="<?php echo $users->email; ?>" readonly>
											<p id="ch_mob"></p>
											<?php echo form_error("email"); ?>

										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">


											<label class="  col-form-label">Date of Birth </label>
											<input type="text" name="dob" class="form-control" id="datepicker1" value="<?php echo date('m/d/Y',strtotime($users->dob)); ?>" readonly="readonly"/>

											<?php echo form_error("dob"); ?>

										</div>
									</div>


									<div class="col-md-6">
										<div class="form-group">


											<label class="  col-form-label">Employee Profile</label>
											<input type="file" name="image" class="form-control"  value=""/>

										</div>
									</div>

								</div>
							</div>
							<div class="card-footer">
								<div class="row">

									<div class="col-lg-12">
										<button type="submit" class="btn btn-sm btn-primary mr-2 float-right ml-2">Update</button> 
										<button type="reset" class="btn btn-sm btn-secondary float-right">Cancel</button>
									</div>

								</div>
							</div>
						</form>
						<!--end::Form-->


						<!--end::Form-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Container-->

			</div>
		</div>


		<script>
														$('#datepicker1').datepicker({
															uiLibrary: 'bootstrap4'
														});
														
													</script>