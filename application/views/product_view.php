<?php //p($_SESSION);                   ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PRODUCT - LIST VIEW</title>
        <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assests/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
        <style>
            .title{font-size:18px;margin-bottom: 20px;}
            .marbottom{margin-bottom: 20px;margin-top: 20px;}
            .btn{
                border-radius: 0px;
                padding-left: 20px;
                padding-right: 20px;
            }
            .marright{margin-right: 20px;}
        </style>
    </head>
    <body>


        <div class="container">
            <div class="row">
                <div class="col-md-12 marbottom">
                    <span class="title">Welcome : <?php echo isset($_SESSION['u_fullname']) ? $_SESSION['u_fullname'] : ''; ?></span>
                    <a href="<?php echo site_url('users/logout'); ?>" class="btn btn-warning pull-right" >Logout</a> &nbsp; &nbsp; &nbsp; &nbsp;
                    <a href="<?php echo site_url('users/addMoreoption'); ?>" class="btn btn-primary pull-right marright" >ADD</a>
                </div>
            </div>
            <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) { ?>
                        <tr>
                            <td><?php echo $product['prod_id']; ?></td>
                            <td><?php echo $product['prod_name']; ?></td>
                            <td><?php echo $product['prod_quantity']; ?></td>
                            <td><?php echo $product['prod_price']; ?></td>
                            <td><?php echo $product['prod_stock']; ?></td>
                            <td><img src="<?php echo IMAGE_PATH . "uploads/" . $product['prod_image']; ?>" width="50" height="50"></td>
                            <td>
                                <a href="<?php echo site_url('users/editProduct/' . $product['prod_id']) ?>"  class="btn btn-warning" ><i class="glyphicon glyphicon-pencil"></i></a>
                                <a onclick="deleteProduct('<?php echo $product['prod_id']; ?>')" class="btn btn-danger" ><i class="glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                </tfoot>
            </table>

            <!--<a class="pull-left btn btn-primary btn-xs" href="<?php echo site_url('users/createXLS') ?>"><i class="fa fa-file-excel-o"></i> Export Data</a>-->
        </div>

        <script src="<?php echo base_url('assests/jquery/jquery-3.1.0.min.js') ?>"></script>
        <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assests/datatables/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assests/datatables/js/dataTables.bootstrap.js') ?>"></script>


        <script type="text/javascript">
                                    function deleteProduct(id)
                                    {
                                        if (confirm('Are you sure delete this data?'))
                                        {
                                            // ajax delete data from database
                                            $.ajax({
                                                url: "<?php echo site_url('users/deleteProduct') ?>/" + id,
                                                type: "POST",
                                                dataType: "JSON",
                                                success: function (data)
                                                {
                                                    if (data.status == '0') {

                                                        location.reload();
                                                    }
                                                }
                                            });

                                        }
                                    }

        </script>
    </body>
</html>
