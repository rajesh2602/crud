<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>USER - REGISTER</title>
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
                        <center><h3>Registration</h3></center>
                        <form action="#" id="form" enctype="multipart/form-data">
                            <div id="alert_msg" class="alert alert-dismissible hide">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <div id="msg"><strong></strong></div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="u_firstname" name="u_firstname" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="u_lastname" name="u_lastname" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="email" class="form-control" id="u_email" name="u_email" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="u_password" name="u_password" placeholder="***********">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="u_cpassword" name="u_cpassword" placeholder="***********">
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Phone</label>
                                    <input type="text" class="form-control" id="u_phone" name="u_phone" placeholder="Phone Number">
                                </div>

                                <div class="form-group">
                                    <label for="profile_pic">Profile Pics</label>
                                    <input type="file" class="form-control" id="u_profile" name="u_profile">
                                </div>

                                <div class="form-group">
                                    <label for="profile_pic">About Me</label>
                                    <textarea name="u_about" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="btnSave" class="btn btn-primary">Register</button>  &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo site_url('users/login'); ?>" class="btn btn-success  " data-dismiss="modal">Login</a>
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
                        u_firstname: {
                            required: true
                        },
                        u_lastname: {
                            required: true
                        },
                        u_email: {
                            required: true,
                            email: true
                        },
                        u_password: {
                            required: true,
                            minlength: 5
                        },
                        u_cpassword: {
                            required: true,
                            minlength: 5,
                            equalTo: '#u_password'
                        },
                        u_profile: {
                            required: true
                        }
                    },
                    submitHandler: function (form,e) {
                        e.preventDefault();
                        var formData = new FormData(form);
                        $.ajax({
                            url: "<?php echo site_url('users/register') ?>",
                            type: "POST",
//                            data: $('#form').serialize(),
                            data: formData,
                            dataType: "JSON",
                            success: function (data) {
                                if (data.status == '0') {
                                    $('#alert_msg').removeClass('hide alert-danger').addClass('alert-success');
                                    $('#msg').text(data.message);

                                } else {
                                    $('#alert_msg').removeClass('hide alert-success').addClass('alert-danger');
                                    $('#msg').text(data.message);
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            });
        </script>
    </body>
</html>
