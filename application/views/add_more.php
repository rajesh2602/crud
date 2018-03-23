<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ADD - REMOVE</title>
        <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
        <style>
            .user_add{
                border: 2px #d4d4d4 solid;
                padding: 20px;
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
            .title{
                font-size: 20px;
            }
            #btnAdd,#btnRemove{margin-top: 26px;}
            .martop{margin-top:20px;}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="user_add">
                        <div class="">
                            <span class="title">Add Product</span>

                        </div>
                        <form action="#" id="form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 martop">
                                    <div id="alert_msg" class="alert alert-dismissible hide">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <div id="msg"><strong></strong></div>
                                    </div>

                                    <div class="form-body" id="mainDIV">
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label for="product_name">Name</label>
                                                <input type="text" class="form-control" id="prod_name" name="prod_name[]" placeholder="Name">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="product_quantity">Quantity</label>
                                                <input type="text" class="form-control" id="prod_quantity" name="prod_quantity[]" placeholder="Quantity">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="product_price">Price</label>
                                                <input type="text" class="form-control" id="prod_price" name="prod_price[]" placeholder="Price">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="product_price">Stock</label>
                                                <input type="text" class="form-control" id="prod_price" name="prod_stock[]" placeholder="Stock">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="product_price">Image</label>
                                                <input type="file" class="form-control" name="prod_image[]" placeholder="image">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <a href="javascript:;" id="btnAdd" class="btn btn-sm btn-primary pull-right">Add More</a> &nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-1"></div>
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
                    submitHandler: function (form,e) {
                        e.preventDefault();
                        var formData = new FormData(form);
                        $.ajax({
                            url: "<?php echo site_url('users/productAdd') ?>",
                            type: "POST",
                            data: formData,
//                            data: $('#form').serialize(),
                            dataType: "JSON",
                            success: function (data) {
                                if (data.status == '0') {
                                    window.location.href = "<?php echo site_url('users/productListView'); ?>";

                                } else {
                                    $('#alert_msg').removeClass('hide').addClass('alert-danger');
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
            var counter = 2;
            $('#btnAdd').click(function () {
                if (counter > 10) {
                    alert("Only 10 textboxes allow");
                    return false;
                }
                var newRowAdd = '<div class="newr"><div class="row"><div class="form-group col-md-2"><label for="product_name">Name</label><input type="text" class="form-control" id="prod_name" name="prod_name[]" placeholder="Name"></div><div class="form-group col-md-2"><label for="product_quantity">Quantity</label><input type="text" class="form-control" id="prod_quantity" name="prod_quantity[]" placeholder="Quantity"></div><div class="form-group col-md-2"><label for="product_price">Price</label><input type="text" class="form-control" id="prod_price" name="prod_price[]" placeholder="Price"></div><div class="form-group col-md-2"><label for="product_price">Stock</label><input type="text" class="form-control" id="prod_price" name="prod_stock[]" placeholder="Stock"></div><div class="form-group col-md-2"><label for="product_price">Image</label><input type="file" class="form-control" id="prod_image" name="prod_image[]" placeholder="image"></div><div class="form-group col-md-2"><a href="javascript:;" id="btnRemove" class="btn btn-sm btn-danger pull-right" onclick="removediv()">Remove</a> &nbsp;&nbsp;&nbsp;</div></div></div>';
                $("#mainDIV").append(newRowAdd);
                counter++;
            });
            function removediv() {
                $('#mainDIV').children("div[class=newr]:last").remove();
            }
        </script>
    </body>
</html>
