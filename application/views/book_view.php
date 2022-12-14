<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Belajar</title>
	
	
	<!-- jquery cdn -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- bootstrap cdn -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/DataTables/css/dataTables.bootstrap.min.css">
	
	
</head>
<body>
	
	<div class="container">
		<center>
			<h1>Belajar Codeigniter with AJAX</h1>
			<h3>Book Store</h3>
		</center>

		<button id="btnAdd" type="button" data-toggle="modal" class="btn btn-primary" onclick="add_book()"><i class="glyphicon glyphicon-plus"></i> Add Book</button>

		<br><br>

		<table id="table_id" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Book ID</th>
					<th>Book ISBN</th>
					<th>Book Title</th>
					<th>Book Author</th>
					<th>Book Category</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; ?>
				<?php foreach ($book as $book) : ?>
				<tr>
					<td><?php echo $no++ ?></td>
					<td><?php echo $book->book_isbn ?></td>
					<td><?php echo $book->book_title ?></td>
					<td><?php echo $book->book_author ?></td>
					<td><?php echo $book->book_category ?></td>
					<td>
						<button class="btn btn-warning btn-sm" onclick="edit_book(<?php echo $book->book_id ?>)" ><i class="glyphicon glyphicon-pencil"></i></button>
						<button class="btn btn-danger btn-sm" onclick="delete_book(<?php echo $book->book_id ?>)" ><i class="glyphicon glyphicon-trash"></i></button>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>


	<!-- jquery -->
	<script src="<?php echo base_url() ?>assets/DataTables/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/DataTables/js/dataTables.bootstrap.min.js"></script>

	
	<!-- js -->
	<script type="text/javascript">

	// datatable
		$(document).ready(function() {
			$('#table_id').dataTable();
		});
	// end datatable 

	// modal
		var save_method;
		var table;

		function add_book()
		{
			save_method = 'add';
			$('#form')[0].reset();
			$('#modal_form').modal('show');
		}

		// insert to database
		function save()
		{
			var url;
			if (save_method=="add") {
				url = "<?php echo base_url('book/book_add') ?>";
			}else {
				url = "<?php echo base_url('book/book_update') ?>";
			}

			$.ajax({
				url: url, 
				type: "POST",
				data: $("#form").serialize(),
				dataType: "JSON",
				success: function(data){
					$("#modal_form").modal("hide");
					location.reload();
				},
				error: function(jqXHR,textStatus, errorThrown){
					alert("Error adding / update data.");
				}
			});
		}

		// edit
		function edit_book(id)
		{
			save_method = 'update';
			$('#form')[0].reset();

			// load data dari ajax
			$.ajax({
				url: "<?php echo base_url('book/ajax_edit/') ;?>/"+id,
				type: "GET",
				dataType: "JSON",
				success: function(data){
					$('[name="book_id"]').val(data.book_id);
					$('[name="book_isbn"]').val(data.book_isbn);
					$('[name="book_title"]').val(data.book_title);  
					$('[name="book_author"]').val(data.book_author);
					$('[name="book_category"]').val(data.book_category);

					$('#modal_form').modal('show');

					$('#modal_title').text('Edit Book');
				},

				error: function(jqXHR,textStatus, errorThrown){
					alert("Error adding / update data.");
				}
			});
		}

		// delete
		function delete_book(id)
		{
			if (confirm("Are you sure delete this data?")) {
				// ajax delete data dari database

				$.ajax({
					url: "<?php echo base_url('book/book_delete') ?>/"+id,
					type: "POST",
					dataType: "JSON",
					success: function(data){
						location.reload();
					},
					error: function(jqXHR,textStatus, errorThrown){
						alert("Error deleting data.");
					}
				});
			}
		}

	</script>
	<div id="modal_form" class="modal fade" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">ADD NEW BOOK</h4>
	      </div>
	      <div class="modal-body form">
	      	<!-- form -->
	        <form action="#" id="form" class="form-horizontal">
	        	<input type="hidden" name="book_id" value="">
	        	<div class="form-body">
	        		<div class="form-group">
	        			<label for="book_isbn" class="control-label col-md-3">Book ISBN</label>
	        			<div class="col-md-9">
	        				<input type="text" class="form-control" id="book_isbn" name="book_isbn" placeholder="Book ISBN">
	        			</div>
	        		</div>
	        		<div class="form-group">
	        			<label for="book_title" class="control-label col-md-3">Book Title</label>
	        			<div class="col-md-9">
	        				<input type="text" class="form-control" id="book_title" name="book_title" placeholder="Book Title">
	        			</div>
	        		</div>
	        		<div class="form-group">
	        			<label for="book_author" class="control-label col-md-3">Book Author</label>
	        			<div class="col-md-9">
	        				<input type="text" class="form-control" id="book_author" name="book_author" placeholder="Book Author">
	        			</div>
	        		</div>
	        		<div class="form-group">
	        			<label for="book_category" class="control-label col-md-3">Book Category</label>
	        			<div class="col-md-9">
	        				<input type="text" class="form-control" id="book_category" name="book_category" placeholder="Book Category">
	        			</div>
	        		</div>
	        	</div>
	        </form>
	        <!-- end form -->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" onclick="save()" class="btn btn-primary">Submit</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>