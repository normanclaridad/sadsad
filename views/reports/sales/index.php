<?php

include($_SERVER['DOCUMENT_ROOT'] . '/inc/app_settings.php');
require_once(SERVER_DOCUMENT_ROOT . '/inc/helpers.php');
require_once(SERVER_DOCUMENT_ROOT . '/models/Events.php');
define('PAGE_TITLE', 'Sales');

$helpers = new Helpers();
$events = new Events();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$resEvents = $events->getWhere("WHERE status != 'D'", "name ASC");

include_once SERVER_DOCUMENT_ROOT . '/templates/header.php';
include_once SERVER_DOCUMENT_ROOT . '/templates/sidebar.php';
?>
<style>
    
    .table>:not(caption)>*>*{
        font-size: 13px;
    }

    .page-header {
        padding-top: 15px;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1><?php echo PAGE_TITLE ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo PAGE_TITLE ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" id="frm-sales" data-parsley-validate="">
                            <h5 class="card-title"><?php echo PAGE_TITLE ?></h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="event" id="event" class="form-control" data-parsley-required="">
                                            <option value="">Select</option>
                                            <?php foreach($resEvents as $event) { ?>
                                                <option value="<?php echo $event['id'] ?>">
                                                    <?php echo $event['name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">&nbsp;</label>
                                    <input type="button" id="btn-search" class="btn btn-primary" value="Generate">
                                </div>
                            </div>
                        </form>
                        <div class="reports">
                            <div class="sales-report">
                                <!-- Sales Report content here -->
                            </div>
                            <div class="entrance-report">
                                <!-- Entrance Report content here -->
                            </div>
                            <div class="dances-report">
                                <!-- Entrance Report content here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<?php
    include_once SERVER_DOCUMENT_ROOT . '/templates/footer.php';
?>
<script>
    $(document).ready(function(){
        $('#btn-search').click(function(){
            if(!$('form#frm-sales').parsley().validate()) {
                return;
            }
            
            var msg = $('.error-message');

            $.ajax({
                url : '<?php echo BASE_URL ?>/api/reports/sales/sales.php',
                type : 'post',
                data : $('#frm-sales').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    //Parse Sales
                    var sales = generateSales(json);
                    //Insert sales to sales report div
                    $('.sales-report').html(sales);
                    
                    //Parse Entrance
                    var entrance = generateEntrance(json);
                    //Insert sales to sales report div
                    $('.entrance-report').html(entrance);
                    
                    //Parse Dances
                    var entrance = generateDances(json);
                    //Insert dances to dances report div
                    $('.dances-report').html(entrance);
                }
            })
        })
    })


    function generateSales(json) {
        var sales = '';
        var header = '<div class="page-header">'+
                        '<h4>Canteen</h4>' +
                    '</div>';
        var table = '<table class="table table-sm table-bordered">';
        var tr = '<tr>' + 
                    '<th rowspan="2">Name</th>' +
                    '<th rowspan="2">Stock</th>' +
                    '<th rowspan="2">Quantity</th>' +
                    '<th colspan="2" class="text-center">Supplier</th>'+
                    '<th colspan="2" class="text-center">Seller</th>' +
                    '<th rowspan="2">Revenue</th>' +
                '</tr>';

            tr += '<tr>' +
                    '<th>Price</th>' +
                    '<th>Amount</th>' +
                    '<th>Price</th>' +
                    '<th>Amount</th>' +
                    // '<th>Revenue</th>' +
                '</tr>';
        $.each(json['sales'], function(){
            tr += '<tr>' + 
                '<td>'+ this['name'] +'</td>' +
                '<td class="text-center">'+ this['stock'] +'</td>' +
                '<td class="text-center">'+ this['total_qty'] +'</td>' +
                '<td class="text-end">'+ this['original_price'] +'</td>' +
                '<td class="text-end">'+ this['orig_product_amount'] +'</td>' +
                '<td class="text-end">'+ this['price'] +'</td>' +
                '<td class="text-end">'+ this['product_amount'] +'</td>' +
                '<td class="text-end">'+ this['revenue'] +'</td>' +
            '</tr>';
        })

        if(json['sales'] != '') {
            tr += '<tr>' + 
                    '<td class="fw-bold" colspan="4">TOTAL</td>' +
                    '<td class="text-end fw-bold">'+ json['supplier_total_amount'] +'</td>' +
                    '<td class="text-end">&nbsp;</td>' +
                    '<td class="text-end fw-bold">'+ json['seller_total_amount'] +'</td>' +
                    '<td class="text-end fw-bold">'+ json['total_revenue'] +'</td>' +
                '</tr>';
        }

        sales = header + table + tr + '</table>';
        return sales;
    }

    function generateEntrance(json) {
        var entrance = '';
        var header = '<div class="page-header">'+
                        '<h4>Entrance</h4>' +
                    '</div>';
        var table = '<table class="table table-sm table-bordered">';
        var tr = '<tr>' + 
                    '<th class="text-center">Name</th>' +
                    '<th class="text-center">Quantity</th>' +
                    '<th class="text-center">Amount</th>'
                '</tr>';
        $.each(json['entrance'], function(){
            tr += '<tr>' + 
                '<td>'+ this['name'] +'</td>' +
                '<td class="text-center">'+ this['quantity'] +'</td>' +
                '<td class="text-end">'+ this['total_amount'] +'</td>' +
            '</tr>';
        })

        if(json['entrance'] != '') {
            tr += '<tr>' + 
                '<td class="fw-bold" colspan="2">TOTAL</td>' +
                '<td class="text-end fw-bold">'+ json['entrance_total_amount'] +'</td>' +
            '</tr>';
        }

        entrance = header + table + tr + '</table>';
        return entrance;
    }

    function generateDances(json) {
        var entrance = '';
        var header = '<div class="page-header">'+
                        '<h4>Curacha/Special Dances</h4>' +
                    '</div>';
        var table = '<table class="table table-sm table-bordered">';
        var tr = '<tr>' + 
                    '<th>Name</th>' +
                    '<th class="text-center">Category</th>' +
                    '<th class="text-center">Amount</th>'
                '</tr>';
        $.each(json['dances'], function(){
            tr += '<tr>' + 
                '<td>'+ this['name'] +'</td>' +
                '<td class="text-center">'+ this['category_name'] +'</td>' +
                '<td class="text-end">'+ this['amount'] +'</td>' +
            '</tr>';
        })

        if(json['dances'] != '') {
            tr += '<tr>' + 
                '<td class="fw-bold" colspan="2">TOTAL</td>' +
                '<td class="text-end fw-bold">'+ json['dances_total_amount'] +'</td>' +
            '</tr>';
        }
        entrance = header + table + tr + '</table>';
        return entrance;
    }
</script>