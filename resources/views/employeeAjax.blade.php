<!DOCTYPE html>
<html>
<head>
    <title>Employee CRUD</title>
    <meta name="empcsrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="container">
    <center><h1>Employee CRUD</h1></center>
    <a class="btn btn-success" id="regemployee" href="javascript:void(0)">Registration</a>
    <table class="table table-bordered empdatatable">
        <thead>
        <tr>
            <th>No</th>
            <th>Fname</th>
            <th>Lname</th>
            <th>DOB</th>
            <th>Address</th>
            <th>City</th>
            <th>Contect no.</th>
            <th>Email</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal face" id="regmodal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalheading"></h4>
            </div>
            <div class="modal-body">
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div><br />--}}
{{--                @endif--}}

                <form id="empform" name="empform" class="form-horizontal" method="post">
                    <input type="hidden" name="eid" id="eid">
                    <div class="form-group">
                        <label for="fname" class="col-sm-4 control-label">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name" value="" maxlength="50" required="">
                        </div>
{{--                        @if ($errors->has('fname'))--}}

{{--                            <span class="text-danger">{{ $errors->first('fname') }}</span>--}}

{{--                        @endif--}}

                    </div>
                    <div class="form-group">
                        <label for="lname" class="col-sm-4 control-label">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dob" class="col-sm-4 control-label">Date of Birth</label>
                        <div class='col-sm-12'>
                            <input type='date' class="form-control" id='dob' name="dob" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-4 control-label">Address</label>
                        <div class='col-sm-12'>
                            <textarea id="address" rows="2" name="address" class="col-sm-12" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-sm-4 control-label">City</label>
                        <div class='col-sm-12'>
                            <select class="form-control" id="city" name="city" required>
                                <option>---- Select city ----</option>
                                <option>Surat</option>
                                <option>Pune</option>
                                <option>Vadodra</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contactnumber" class="col-sm-4 control-label">Contact number</label>
                        <div class='col-sm-12'>
                            <input type="text" name="contactnumber" class="form-control" id="contactnumber" maxlength="10" pattern="\d{10}" required/>
{{--                            <input type="number" class="form-control" id="contact"  min="10" max="10" required/>--}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Email</label>
                        <div class='col-sm-12'>
                            <input type="email" class="form-control" id="email" name="email" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-4 control-label">Password</label>
                        <div class='col-sm-12'>
                            <input type="password" class="form-control" id="password" name="password" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword" class="col-sm-10 control-label">Confirm Password</label>
                        <div class='col-sm-12'>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <center>
                            <button type="submit" name="submit" class="btn btn-primary col-sm-10" id="regbtn" value="Register">Register
                            </button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="empcsrf-token"]').attr('content')
            }
        });
        var table = $('.empdatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'fname', name: 'fname'},
                {data: 'lname', name: 'lname'},
                {data: 'dob', name: 'dob'},
                {data: 'address', name: 'address'},
                {data: 'city', name: 'city'},
                {data: 'contactnumber', name: 'contactnumber'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action'},
            ]
        });
        $('#regemployee').click(function () {
            $('#eid').val('');
            $('#empform').trigger("reset");
            $('#modalheading').html('Employee Registration');
            $('#regmodal').modal('show');
        });
        $('#regbtn').click(function (e) {
            var formdata = $('#empform').serialize();
            console.log('Form Daata :'+formdata);
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#empform').serialize(),
                url: "{{ route('employees.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#empform').trigger("reset");
                    $('#regmodal').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:'+data);
                    $('#regbtn').html('Save Changes');
                }
            });
        });
        $('body').on('click', '.editemp', function () {
            var e_id = $(this).data('id');
            $.get("{{ route('employees.index') }}" +'/' + e_id +'/edit', function (data) {
                $('#modalheading').html('Edit Employee Details');
                $('#regbtn').val("edit-user");
                $('#regmodal').modal('show');
                $('#e_id').val(data.id);
                $('#fname').val(data.fname);
                $('#lname').val(data.lname);
                $('#dob').val(data.dob);
                $('#address').val(data.address);
                $('#city').val(data.city);
                $('#contactnumber').val(data.contactnumber);
                $('#email').val(data.email);
                $('#password').val(data.password);
                $('#confirmpassword').val(data.confirmpassword);
            })
        });
        $('body').on('click', '.deleteemp', function () {
            var e_id = $(this).data("id");
            confirm("Are You sure want to delete !");
            $.ajax({
                type: "DELETE",
                url: "{{ route('employees.store') }}" + '/' + e_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });
</script>

