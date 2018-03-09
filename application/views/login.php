<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>USER - LOGIN</title>
        <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
        <style>
            .user_add{
                border: 2px #d4d4d4 solid;
                padding: 20px 50px 20px 50px;
                border-radius: 5px;
                margin-top: 10%;
            }
            .form-control{border-radius: 0px;}
            .btn{
                border-radius: 0px;
                padding-left: 20px;
                padding-right: 20px;
            }
            .error{
                color: red;
                font-size: 12px;
                margin-top: 3px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="user_add">
                        <center><h3>Login</h3></center>
                        <form action="#" id="form" enctype="multipart/form-data">
                            <div id="alert_msg" class="alert alert-dismissible hide">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <div id="msg"><strong></strong></div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="email" class="form-control" id="u_email" name="u_email" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="u_password" name="u_password" placeholder="***********">
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="btnSave" class="btn btn-primary">Login</button> &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url('users'); ?>" class="btn btn-success  " data-dismiss="modal">Register</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

        <script src="<?php echo base_url('assests/jquery/jquery-3.1.0.min.js') ?>"></script>
        <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assests/datatables/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assests/datatables/js/dataTables.bootstrap.js') ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function () {
                $('#form').validate({
                    rules: {
                        u_email: {
                            required: true,
                            email: true
                        },
                        u_password: {
                            required: true,
                        }
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            url: "<?php echo site_url('users/checkLogin') ?>",
                            type: "POST",
                            data: $('#form').serialize(),
                            dataType: "JSON",
                            success: function (data) {
                                if (data.status == '0') {
                                    window.location.href = "<?php echo site_url('users/userListView');?>";

                                } else {
                                    $('#alert_msg').removeClass('hide').addClass('alert-danger');
                                    $('#msg').text(data.message);
                                }
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
