<html>
<head>
    <title>DataTables</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
</head>
<body>
<style>
    .error {
        color: red;
    }
</style>
<div class="container">
    <!-- Trigger the modal with a button -->
    <button type="button" class="editor_create btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Thêm
        mới
    </button>

    <div class="modal fade" id="myModal" role="dialog">
        <form id="FormUser" action="" method="POST">
            {{csrf_field()}}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title titleOK">Thêm user</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input type="text" name="userName" class="form-control" id="usr">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Email:</label>
                            <input type="email" name="userEmail" class="form-control" id="userEmail">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" name="userPassword" class="form-control" id="pass">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default BTNSubmit BTNcreate">Create</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
<br>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th>Edit/Delete</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</body>
<script>
    // validate js
    $(document).ready(function () {
        var validateRule = {
            create: {
                userName: {
                    required: true,
                    minlength: 5
                },
                userEmail: {
                    required: true,
                    email: true,
                    remote: "{{route('shop.uses.CheckEmail')}}"

                },
                userPassword: {
                    required: true,
                    minlength: 6

                },
            },
            update: {
                userName: {
                    required: true,
                    minlength: 5
                },
                userPassword: {
                    required: true,
                    minlength: 6

                },
            }
        };
        var VALIDATE = {};

        var HtmlForm = $('#myModal').html();
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('shop.product.product')}}",
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "email"},
                {"data": "created_at"},
                {"data": "updated_at"},
                {
                    data: "id",
                    className: "center",
                    render: function (data) {
                        return '<a  data-id="' + data + '" class="editor_edit">Edit</a> / <a href="" class="editor_remove clickDelete" data-id="' + data+ '">Delete</a>'
                    }
                }
            ]
        });

// open model Edit
        $(document).on('click', '.editor_edit', function (event) {
            event.preventDefault();
            $('#FormUser').find('input[name=id]').remove();
            var $this = $(this);
            var $_this = $this.closest('tr');
            var id = $this.attr('data-id');
            var userName = $_this.find('td:nth-child(2)').text();
            $('#myModal input[name=userEmail]').attr('readonly', true);
            $('#myModal input[name=userName]').val(userName);
            $('#myModal input[name=userEmail]').val($_this.find('td:nth-child(3)').text());
            $('#myModal .BTNSubmit').html('<i class="fa fa-save"> Cập nhật');
            $('#myModal .BTNSubmit').removeClass('BTNcreate');
            $('#myModal  .titleOK').html("Cập nhât [ " + userName + " ]");
            $('#FormUser').prepend('<input type="hidden" value="' + id + '" name="id">');
            $('#myModal').modal('show');
            validateUser(validateRule.update);

        });
        // $(document).on('click', '.BTNSubmit', function(event) {
        //     event.preventDefault();
        //     var url =  $('#FormUser').attr('action');
        //     var data = $('#FormUser').serializeArray();
        //     $.ajax({
        //        url: "{{route('shop.uses.editPost')}}",
        //        type: 'POST',
        //        dataType: 'json',
        //        data: data,
        //    })
        //     .done(function(data) {
        //         // var $_this = $('.editor_edit[data-id='+data.id+']').closest('tr');
        //         // $_this.find('td:nth-child(2)').text(data.name);
        //         // $_this.find('td:nth-child(3)').text(data.email);
        //         // $_this.find('td:nth-child(5)').text(data.updated_at);
        //         //khuyen dung cach tren
        //          table.ajax.reload();
        //         $('#myModal').modal('hide');
        //     }).fail(function() {
        //       alert('Đã Có Lỗi Xẩy RA VUI Lòng THử Lại');
        //   })

        // });
        $('#myModal').on('hidden.bs.modal', function () {
            $('#myModal').html(HtmlForm);
        })
        $('#example').on('click', '.clickDelete', function (e) {
            e.preventDefault();
            if (confirm("Bạn có chắc muốm xóa id này không ?")) {
                var $this = $(this);
                var id = $(this).data('id');
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{route('shop.product.delete')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {"_token": token, "id": id},
                })
                    .done(function (data) {
                        table.ajax.reload();
                        // $('.editor_edit[data-id='+id+']').closest('tr').remove();
                    }).fail(function () {
                    alert('Đã Có Lỗi Xẩy RA VUI Lòng THử Lại');
                })
            }
        });
    // open model Create
        $(document).on('click', '.editor_create', function () {
            $('#myModal .BTNcreate').removeClass('BTNSubmit');
            // VALIDATE = validateRule.create;
            validateUser(validateRule.create);
        });

        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });

        function validateUser(typeRule) {
            typeRule || (typeRule = validateRule.create);
            $("#FormUser").validate({
                ignore: [],
                debug: false,
                rules: typeRule,
                messages: {
                    userName: {
                        required: "Vui lòng nhập vào đây",
                        minlength: "User name ít nhất 4 ký tự"
                    },
                    userEmail: {
                        required: "Vui lòng nhập vào đây",
                        email: "Email chưa đúng định dạng",
                        remote: "Email đã tồn tại!"
                    },
                    userPassword: {
                        required: "Vui lòng nhập vào đây",
                        minlength: "Password name ít nhất 5 ký tự"
                    }
                },
                submitHandler: function (form) {
                    if ($("#FormUser").find(".BTNSubmit").length === 1) {
                        //ajax Edit
                        event.preventDefault();
                        var url = $('#FormUser').attr('action');
                        var data = $('#FormUser').serializeArray();
                        $.ajax({
                            url: "{{route('shop.uses.editPost')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                        })
                            .done(function (data) {
                                // var $_this = $('.editor_edit[data-id='+data.id+']').closest('tr');
                                // $_this.find('td:nth-child(2)').text(data.name);
                                // $_this.find('td:nth-child(3)').text(data.email);
                                // $_this.find('td:nth-child(5)').text(data.updated_at);
                                //đoạn code trên tối ưu hơn.
                                table.ajax.reload();
                                $('#myModal').modal('hide');
                            }).fail(function () {
                            alert('Đã Có Lỗi Xãy RA VUI Lòng Thử Lại');
                        })
                    } else if ($("#FormUser").find(".BTNcreate").length === 1) {
                        //ajax add
                        var url = $('#FormUser').attr('action');
                        var data = $('#FormUser').serializeArray();
                        $.ajax({
                            url: "{{route('shop.uses.Create')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                        }).done(function (data) {
                            table.ajax.reload();
                            $('#myModal').modal('hide');
                        }).fail(function () {
                            alert('co lỗi xãy ra khi thêm');

                        })
                    };
                }
            });
        }
    });
</script>
</html>