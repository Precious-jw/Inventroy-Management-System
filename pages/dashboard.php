<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                Total Amount of Products Sold</div>
                            <?php
                            $sql = "SELECT SUM(total_price) AS total_amount from sales";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result()->fetch_object()->total_amount;
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?= number_format($result); ?></div>
                            <?php
                            $stmt->close();
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                Total Inventory Amount</div>
                            <?php
                            $final_total = 0;
                            $sql = "SELECT * from product";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                foreach ($result as $row) {
                                    $total = $row['purchase_price'] * $row['product_qty'];
                                    $final_total += $total;
                                }
                            }
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;<?= number_format($final_total); ?></div>
                            <?php
                            $stmt->close();
                            ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-warning text-uppercase mb-1">
                                Number of Different Products in Inventory</div>
                            <?php
                            $sql = "SELECT * from product";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $result->num_rows; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-warning text-uppercase mb-1">
                                Inventory amount</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>  -->
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 mt-2 text-primary text-bold">Recent Sales List</h6>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url ?>?page=sales" class="btn btn-primary btn-sm">View all</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Loader -->
                    <div id="loader-container">
                        <div class="loader"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-gray-900" id="dataTable">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Customer Name</th>
                                    <th>Customer phone no.</th>
                                    <th>List of Products</th>
                                    <th>Qty</th>
                                    <th>Total Price</th>
                                    <th>Payment method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT *, sales.id AS sales_id from sales ORDER BY sales_id DESC LIMIT 10";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $num = 1;

                                    foreach ($result as $row) {
                                ?>
                                        <tr>
                                            <td><?= $num; ?></td>
                                            <td><?= $row['date']; ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_phone']; ?></td>
                                            <td><?= $row['products']; ?></td>
                                            <td><?= $row['quantity']; ?></td>
                                            <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                            <td><?= $row['payment_method']; ?></td>
                                        </tr>
                                <?php
                                        $num++;
                                    }
                                }
                                $stmt->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->