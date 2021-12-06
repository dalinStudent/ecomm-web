@extends('dashboardadmin.adminpage')
	@section('content')
    <div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
                    <h2 class="title1">List All Order</h2>
					<div class="table-responsive bs-example widget-shadow">
                    <a href="{!!url('/createorder')!!}" type="sumit" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Add order</a>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>#Id</th>
									<th>shipping address</th>
									<th>order address</th>
									<th>order date</th>
									<th>order status </th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">1</th>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>
										<a href="#" class="text-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<a href="#" class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
										<a href="#" class="text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
									</td>
								</tr>
								<tr>
									<th scope="row">2</th>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>
										<a href="#" class="text-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<a href="#" class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
										<a href="#" class="text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
									</td>
								</tr>
								<tr>
									<th scope="row">3</th>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>Table cell</td>
									<td>
										<a href="#" class="text-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<a href="#" class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
										<a href="#" class="text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    @endsection