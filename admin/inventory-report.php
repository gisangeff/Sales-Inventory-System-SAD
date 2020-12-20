﻿<?php
    require '../application/config/connection.php';
    require_once '../application/config/functions.php';
    
    session_start();

    $query = "SELECT products.id, products.name, products.price, products.QuantityInStock, products.QuantitySold, supplier.name as 'supplier_name', category.name as 'category_name', products.date_added FROM products INNER JOIN category ON products.category_id = category.id INNER JOIN supplier ON products.supplier_id = supplier.id WHERE products.QuantityInStock > 0";

    if (isset($_POST['search'])) {
        if (isset($_POST['date-from']) && isset($_POST['date-to'])) {

        $query .= " AND DATE_FORMAT(products.date_added,'%m/%d/%Y') BETWEEN '".$_POST['date-from']."' AND '".$_POST['date-to'] . '23:59:00' ."'";
        }
  
      }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Inventory Report</title>

    <!-- links -->
    <?php include 'sections/links.php'; ?>

</head>

<body class="theme-teal">
    <!-- Page Loader -->
    <?php include 'sections/page-loader.php'; ?>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Top Bar -->
    <?php include 'sections/top-bar.php'; ?>

    <!-- Left Side Bar -->
    <?php include 'sections/left-sidebar/leftsidebar.php'; ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>INVENTORY REPORT</h2>
            </div>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>List of Products</h2>
                        </div>
                        <div class="body">
                            <form method="post">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-3 col-sm-3 col-xs-6">
                                        <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="date-from"
                                                    placeholder="Date start...">
                                            </div>
                                            <span class="input-group-addon">to</span>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="date-to"
                                                    placeholder="Date end...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <button type="submit" name="search"
                                            class="btn bg-blue-grey btn-sm waves-effect">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable"
                                    id="products-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Sold</th>
                                            <th>Supplier</th>
                                            <th>Category</th>
                                            <th>Date Added</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                    try {

                                        $rows = $function->selectAll($query);
                                        foreach ($rows as $row) { ?>

                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td>
                                                <span
                                                    class="label bg-<?php echo ($row['QuantityInStock']<=30) ? 'red' : 'green'; ?>">
                                                    <?php echo $row['QuantityInStock']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $row['QuantitySold']; ?></td>
                                            <td><?php echo $row['supplier_name']; ?></td>
                                            <td><?php echo $row['category_name']; ?></td>
                                            <td><?php echo $row['date_added']; ?></td>
                                        </tr>

                                        <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "There is some problem in connection: " . $e->getMessage();
                                    }

                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>

    <!-- scripts -->
    <?php include 'sections/scripts.php'; ?>

</body>

</html>