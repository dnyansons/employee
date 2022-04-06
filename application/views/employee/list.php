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
							<h5 class="text-dark font-weight-bold my-2 mr-5">Employee List</h5>
							<!--end::Page Title-->

						</div>
						<!--end::Page Heading-->
					</div>
					<!--end::Info-->
					<div class="card-toolbar"> 

						<!--begin::Button-->
						<a href="<?php echo base_url(); ?>employee/add" class="btn btn-primary font-weight-bolder">
							<span class="fa fa-plus"></span> Add Employee</a>
							<!--end::Button-->
						</div>

					</div>
				</div>
				<!--end::Subheader-->
				<!--begin::Entry-->
				<div class="d-flex flex-column-fluid">
					<!--begin::Container-->
					<div class="container">

						<!--begin::Card-->
						<div class="card card-custom gutter-b">

							<?php echo $this->session->flashdata('message'); ?>
							<div class="card-body" style="overflow: auto;">
								<!--begin: Datatable-->

								<table class="table table-bordered table-head-custom" id="datatable">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Address</th>
											<th>Mobile</th>
											<th>Email</th>
											<th>Date of Birth</th>
											<th>Image</th>
											<th>Created&nbsp;At</th>
											<th style="width:110px;">Action</th>
										</tr>
									</thead>
									<tbody>


									</tbody>
								</table>
								<!--end: Datatable-->
							</div>
						</div>
						<!--end::Card-->




					</div>
					<!--end::Container-->
				</div>
				<!--end::Entry-->
			</div>

			<script>
				$(document).ready(function () {

					$('#datatable').DataTable({
						processing: true,
						serverSide: true,
						searching: true,
            //dom: 'Bfrtip',
            ajax: {
            	url: "<?php echo base_url('employee/ajax_list'); ?>",
            	dataType: "json",
            	type: "POST",
            	data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            columns: [
            {data: "id"},
            {data: "name"},
            {data: "address"},
            {data: "mobile"},
            {data: "email"},
            {data: "dob"},
            {data: "image"},
            {data: "created_at"},
            {data: "action"}
            ],
            "aaSorting": [[ 0, "desc" ]],
            "lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]]
        });

				});

			</script>

			

			<script>
				$(document).ready(fuction(){
					alert('done');
				});

			</script>