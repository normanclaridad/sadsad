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
                            <div class="transactions-report">
                                <!-- Transactions Report content here -->
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
                url : '<?php echo BASE_URL ?>/api/reports/transactions/transactions.php',
                type : 'post',
                data : $('#frm-sales').serialize(),
                success : function(data) {
                    var json = $.parseJSON(data);

                    //Parse Transactions
                    var sales = generateTransactions(json);
                    //Insert sales to sales report div
                    $('.transactions-report').html(sales);                    
                }
            })
        })
    })


    function generateTransactions(json) {
        var sales = '';
        var header = '<div class="page-header">'+
                        '<h4>Transactions</h4>' +
                    '</div>';
        var table = '<table class="table table-sm table-bordered">';
        var tr = '<tr>' + 
                    '<th>Transacton #</th>' +
                    '<th>Name</th>' +
                    '<th>Amount</th>' +
                    '<th class="text-center">Amount <br> Paid</th>'+
                    '<th class="text-center">Change</th>' +
                    '<th class="text-center">Good For<br>(Utang)</th>' +
                    '<th class="text-center">Date/Time</th>' +
                '</tr>';
        $.each(json['transactions'], function(){
            tr += '<tr>' + 
                '<td>'+ this['transaction_no'] +'</td>' +
                '<td>'+ this['customer_name'] +'</td>' +
                '<td class="text-end">'+ this['total_amount'] +'</td>' +
                '<td class="text-end">'+ this['amount_paid'] +'</td>' +
                '<td class="text-end">'+ this['amount_change'] +'</td>' +
                '<td class="text-end">'+ this['good_for'] +'</td>' +
                '<td class="text-center">'+ this['created_at'] +'</td>' +
            '</tr>';
        })

        if(json['sales'] != '') {
            tr += '<tr>' + 
                    '<td class="fw-bold" colspan="2">TOTAL</td>' +
                    '<td class="text-end fw-bold">'+ json['total_amount'] +'</td>' +
                    '<td class="text-end">&nbsp;</td>' +
                    '<td class="text-end">&nbsp;</td>' +
                    '<td class="text-end fw-bold">' + json['total_good_for'] + '</td>' +
                    '<td class="text-end">&nbsp;</td>' +
                '</tr>';
        }

        sales = header + table + tr + '</table>';
        return sales;
    }
</script>