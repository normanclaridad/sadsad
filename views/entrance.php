<?php
include('../inc/app_settings.php');
require_once('../inc/helpers.php');
require_once('../models/Prices.php');
require_once('../models/Events.php');
require_once('../models/Entrance_prices.php');

$events = new Events();
$prices = new Prices();
$helpers = new Helpers();
$entrancePrices = new Entrance_prices();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

$resEvents = $events->getWhere("WHERE status = 'Y' AND start <= '". date('Y-m-d H:i:s') ."' AND end >= '". date('Y-m-d H:i:s') ."'");
$message = '';
if(empty($resEvents)) {
    $message = 'No event set for today!';
}

if(count($resEvents) > 1) {
    $message = 'More than One(1) event enabled. It should only one(1) event should be enabled.';   
}

$eventId = (count($resEvents) == 1) ? $resEvents[0]['id'] : 0;

include_once '../templates/header.php';
include_once '../templates/sidebar.php';
$where = " WHERE status = 'Y' AND event_id = $eventId";

$resEntrancePrice = $entrancePrices->getWhere($where);
$message = '';
if(empty($resEntrancePrice)) {
    $message = 'No price being set. Contact administrator.';
}

?>
<style>
    @media(max-width: 767px){
        #main {
            padding: 0px;
        }

        .table>:not(caption)>*>*{
            font-size: 13px;
        }
    }
    /* #male-quantity,#female-quantity, #kids-quantity,#table-quantity, #customer_name, #cash, #change {
        width: 70px;
    } */
    .sub-total {
        font-weight: 800;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entrance                       
                            <span class="float-end">
                                <a class="btn btn-sm btn-primary" id="btn-add">
                                    <i class="ri-add-circle-line"></i>
                                </a>
                            </span>
                        </h5>
                        <table class="table datatable" id="table-data">
                            <thead>
                            <tr>
                                <th>Trxn No</th>
                                <th>
                                    Total
                                </th>
                                <th>
                                    Cash
                                </th>
                                <th>
                                    Change
                                </th>
                                <!-- <th>Transaction Date/Time</th> -->
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<div class="modal fade" id="products" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 13px 5px 17px;">
                <h5 class="modal-title">Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                <form id="frm-orders" data-parsley-validate="">
                    <input type="hidden" name="id" value="<?php echo $resEntrancePrice[0]['id'] ?>">
                    <input type="hidden" id="action_type" name="action_type" value="add">
                    <div class="error-message">
                    </div>
                    <table class="table table-responsive">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Price</th>
                            <th style="width: 120px;">Quantity</th>
                            <th class="text-center">Total</th>
                        </tr>
                        <tr>
                            <td>Male</td>
                            <td>
                                <?php echo number_format($resEntrancePrice[0]['male'],2) ?>
                            </td>
                            <td>
                                <!-- <input type="number" id="male-quantity" class="qty text-center" placeholder="0" data-field-name="male" data-price="<?php echo $resEntrancePrice[0]['male'] ?>"> -->
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary btn-danger btn-number" data-type="minus" type="button" id="button-addon1">
                                        <span class="bi bi-dash"></span>
                                    </button>
                                    <input type="text" id="male-quantity" class="form-control input-number qty text-center"  max="100" data-field-name="male" data-price="<?php echo $resEntrancePrice[0]['male'] ?>" placeholder="0">
                                    <button class="btn btn-outline-secondary btn-success btn-number" data-type="plus" type="button" id="button-addon1">
                                        <span class="bi bi-plus"></span>
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">
                                <span class="sub-total">0.00</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Female</td>
                            <td>
                                <?php echo number_format($resEntrancePrice[0]['female'],2) ?>
                            </td>
                            <td>
                                <!-- <input type="number" id="female-quantity" class="qty text-center" placeholder="0" data-field-name="female" data-price="<?php echo $resEntrancePrice[0]['female'] ?>"> -->
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary btn-danger btn-number" data-type="minus" type="button" id="button-addon1">
                                        <span class="bi bi-dash"></span>
                                    </button>
                                    <input type="text" id="female-quantity" class="form-control input-number qty text-center" max="100" data-field-name="female" data-price="<?php echo $resEntrancePrice[0]['female'] ?>" placeholder="0">
                                    <button class="btn btn-outline-secondary btn-success btn-number" data-type="plus" type="button" id="button-addon1">
                                        <span class="bi bi-plus"></span>
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">
                                <span class="sub-total">0.00</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Kids</td>
                            <td>
                                <?php echo number_format($resEntrancePrice[0]['kids'],2) ?>
                            </td>
                            <td>
                                <!-- <input type="number" id="kids-quantity" class="qty text-center" placeholder="0" data-field-name="kids" data-price="<?php echo $resEntrancePrice[0]['kids'] ?>"> -->
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary btn-danger btn-number" data-type="minus" type="button" id="button-addon1">
                                        <span class="bi bi-dash"></span>
                                    </button>
                                    <input type="text" id="kids-quantity" class="form-control input-number qty text-center" max="100" data-field-name="kids" data-price="<?php echo $resEntrancePrice[0]['kids'] ?>" placeholder="0">
                                    <button class="btn btn-outline-secondary btn-success btn-number" data-type="plus" type="button" id="button-addon1">
                                        <span class="bi bi-plus"></span>
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">
                                <span class="sub-total">0.00</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Table</td>
                            <td>
                                <?php echo number_format($resEntrancePrice[0]['table_charge'],2) ?>
                            </td>
                            <td>
                                <!-- <input type="number" id="table-quantity" class="qty text-center" placeholder="0" data-field-name="table-charge" data-price="<?php echo $resEntrancePrice[0]['table_charge'] ?>"> -->
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary btn-danger btn-number" data-type="minus" type="button" id="button-addon1">
                                        <span class="bi bi-dash"></span>
                                    </button>
                                    <input type="text" id="table-quantity" class="form-control input-number qty text-center" max="100" data-field-name="table-charge" data-price="<?php echo $resEntrancePrice[0]['male'] ?>" placeholder="0">
                                    <button class="btn btn-outline-secondary btn-success btn-number" data-type="plus" type="button" id="button-addon1">
                                        <span class="bi bi-plus"></span>
                                    </button>
                                </div>
                            </td>
                            <td class="text-end">
                                <span class="sub-total">0.00</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-weight: 800">
                                TOTAL
                            </td>
                            <td class="text-end">
                                <span class="total-amount" style="font-weight: bold; font-size: 20px;">0.00</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" value="Customer" id="customer_name" placeholder="Customer Name" style="width: 120px;">
                            </td>
                            <td>
                                <input type="number" id="cash" class="text-end" data-parsley-required="" placeholder="Cash" style="width: 85px;">
                            </td>
                            <td>
                                <input type="number" id="change" class="text-end" style="width: 85px;" placeholder="Change" data-parsley-required="">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- End Vertically centered Modal-->

<!-- View -->
<div class="modal fade" id="view-transactions" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 13px 5px 17px;">
                <h5 class="modal-trxn-title">Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table">
                        <tr>
                            <td class="cust-view">Customer</td>
                            <td class="cust-name fw-bold"></td>
                            <td class="cust-view">Total Amount</td>
                            <td class="cust-total-amount fw-bold"></td>
                            <td class="cust-view">Amount Paid</td>
                            <td class="cust-amount-paid fw-bold"></td>
                            <td class="cust-view">Change</td>
                            <td class="cust-change fw-bold"></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table class="table table-responsive" id="tbl-view-products">
                        
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
    include_once '../templates/footer.php';
?>
<script>
    $(document).ready(function(){

        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo BASE_URL ?>/api/get-entrances.php',
                type: 'POST',
                data:   function ( d ) {
                    return $.extend( {}, d, {
                        'event_id' : '<?php echo $eventId ?>' 
                    } );
                },
                "dataSrc": function ( json ) {
                    
                    if($('#action').val() == 'excel') {
                        window.open(json.url, '_blank');
                    }

                    if($('#action').val() == 'print') {
                        // window.open(json.url);
                        createPopupWin(json.url, 'Lots')
                    }
                    return json.data;
                }                    
            },
            "columnDefs": [ {
                "targets": [4],
                "orderable": false
            } ],
            "order": []
        });
        $('#btn-save').click(function(){

            if(!checkProduct()){
                alert('No entrance fee found!');
                return;
            }

            var orders = [];
            $('.qty').each(function(){
                var order = {};
                var qty = $(this).val();

                order.field_name = $(this).data('field-name');
                order.price = $(this).data('price');
                order.quantity = qty;
                orders.push(order);
            })

            var formData = {
                action_type : $('#action_type').val(),
                customer_name : $('#customer_name').val(),
                cash : $('#cash').val(),
                change : $('#change').val(),
                total_amount : $('.total-amount').text()
            }

            var data = {
                form : formData,
                orders: orders
            };

            if(!$('form#frm-orders').parsley().validate()) {
                return;
            }

            var msg = $('.error-message');

            if(confirm('Are all data is correct?')){ 

                $.ajax({
                    url : '<?php echo BASE_URL ?>/api/entrance.php',
                    type : 'post',
                    data : data,
                    success : function(data) {
                        var json = $.parseJSON(data);
                        alert(json['message']);
                        if(json['code'] == 0) {
                            // $('#products').modal('hide');
                            // table.ajax.reload();
                            location.reload();
                        }
                    }
                })
            }
            return false;
        })

        $('#cash').maskMoney();
        $('#change').maskMoney();
        $('#cash').keypress(function(){
            var cash = $(this).maskMoney('unmasked')[0];
            var amount = $('.total-amount').text();
            var change = parseFloat(cash) - parseFloat(amount);

            $('#change').val(change.toFixed(2));
        })
        $('#btn-add').click(function(){
            <?php if(empty($resEntrancePrice)) { ?>
                alert('<?php echo $message ?>');
                return;
            <?php } ?>
            $('.modal-title').html('New Transaction');
            $('#action_type').val('add');
            $('#male-quantity').val('0');
            $('#female-quantity').val('0');
            $('#kids-quantity').val('0');
            $('#table-quantity').val('0');
            $('#products').modal('show');
        })

        $('#product_id').change(function(){
            // var data = $(this).select2('data');
            var price = $(this).find(':selected').data('selling-price');
            var unit_name = $(this).find(':selected').data('unit');

                price = parseFloat(price);
            var product_name = $(this).find(':selected').data('product-name');
            
            $('#unit').val(unit_name);
            $('#price').val(price.toFixed(2));
            $('#product-name').val(product_name);
        })

        $('#quantity').keyup(function(){
            var qty = $(this).val();
                qty = parseFloat(qty);
            var price = $('#price').val();
            var amount = qty * parseFloat(price);

            $('#amount').val(amount.toFixed(2));
        })

        $('#btn-add-order').click(function(){

            if(!$('form#frm-products').parsley().validate()) {
                return;
            }

            var tbl = $('#tbl-products');

            var tr = '<tr class="ordered-product" data-id="'+ $('#product_id').val() +'" data-price="'+ $('#price').val() +'" data-unit-id="'+ $('#product_id').find(':selected').data('unit-id') +'" data-product-id="'+ $('#product_id').find(':selected').data('product-id') +'">';
                tr += '<td>' + $('#product-name').val() + '</td>';
                tr += '<td>' + '<input type="number" class="qty-order" value="'+ $('#quantity').val() + '" style="width: 70px;" />' + '</td>';
                tr += '<td>' + $('#unit').val() + '</td>';
                tr += '<td>' + $('#price').val() + '</td>';
                tr += '<td class="text-end sub-amount">' + $('#amount').val() + '</td>';
                tr += '<td>' + '<span class="btn btn-sm btn-danger" onclick="remove(this)"><i class="bi bi-x-circle"></i></span>' + '</td>';
                tr += '</tr>';
            // console.log(tr);
            tbl.append(tr);

            $('#product_id').val('');
            $('#product_id').trigger('change.select2');
            $('form#frm-products')[0].reset();
            totalOrder();
        })
    })
    
    // $(document).on('keyup', '.qty', function(){
    //     // console.log();
    //     var quantity = $(this).val();

    //     // if($(this).is(':empty')){
    //     //     quantity = 0;
    //     // }

    //     var price = $(this).data('price');
    //     var amount = parseFloat(quantity) * parseFloat(price);

    //     $(this).parent().parent().find('td').eq(3).find('span.sub-total').text(amount.toFixed(2));
    //     totalOrder();
    // });

    // $(document).on('click', '.qty', function(){
    //     $(this).trigger('keyup');
    // });

    $(document).on('click', '.btn-number', function(){
        // console.log($(this).parent().find('input').val());
        var num = $(this).parent().find('input').val();
        var type = $(this).data('type');
        var x = 0;
        
        if(num == '') {
            num = 0;
        }

        if(type == 'plus') {
            x = parseInt(num);
            x++;
        }

        if(type == 'minus') {
            x = parseInt(num);
            if(x >= 1) {
                x--;
            }
        }
        // console.log(x);
        $(this).parent().find('input').val(x);

        //Computation
        var price = $(this).parent().find('input').data('price');
        var amount = parseFloat(x) * parseFloat(price);

        $(this).parent().parent().parent().find('td').eq(3).find('span.sub-total').text(amount.toFixed(2));
        totalOrder();
    })

    
    $(document).on('click', 'a.btn-view', function(){
        $('.modal-trxn-title').text('Transaction ' + $(this).data('transaction-no'));
        var id = $(this).data('id');
        $.ajax({
                url : '<?php echo BASE_URL ?>/api/view-transactions.php',
                type : 'post',
                data : { action_type : 'delete', 'id' : id },
                success : function(data) {
                    var json = $.parseJSON(data);
                    
                    // console.log(json['name']);
                    $('.cust-name').text(json['name']);
                    $('.cust-total-amount').text(json['total_amount']);
                    $('.cust-amount-paid').text(json['amount_paid']);
                    $('.cust-change').text(json['amount_change']);

                    var tbltrxn = $('#tbl-view-products');
                    var tr = '';
                    tr += '<thead>';
                    tr += '    <tr>';
                    tr += '        <th>Products</th>';
                    tr += '        <th>Quantity</th>';
                    tr += '        <th>Unit</th>';
                    tr += '        <th>Price</th>';
                    tr += '        <th>Total</th>';
                    tr += '    </tr>';
                    tr += '</thead>';
                    tr += '<tbody>';
                    $.each(json['trxndetails'], function(){
                            tr += '<tr>';
                            tr += '<td>' + this['product_name'] + '</td>';
                            tr += '<td>' + this['qty'] + '</td>';
                            tr += '<td>' + this['unit_name'] + '</td>';
                            tr += '<td class="text-end">' + this['price'] + '</td>';
                            tr += '<td class="text-end">' + this['total'] + '</td>';
                            tr += '</tr>';
                    });

                    tr += '</tbody>';
                    tr += '<tfoot>';
                    tr += '    <tr>';
                    tr += '        <th colspan="4">TOTAL</th>';
                    tr += '        <th class="total-order-amount text-end"></th>';
                    tr += '</tfoot>';

                    tbltrxn.html(tr);

                    $('.total-order-amount').text(json['total_amount']);
                }
            })

        $('#view-transactions').modal('show');
    });
    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var transaction_no = $(this).data('transaction-no');

        // if(confirm('Are you sure you want delete transaction: ' + transaction_no + '?'))
        // {
        //     $.ajax({
        //         url : '<?php echo BASE_URL ?>/api/del-pos.php',
        //         type : 'post',
        //         data : { action_type : 'delete', 'id' : id },
        //         success : function(data) {
        //             var json = $.parseJSON(data);
        //             if(json['code'] == 0) {
        //                 alert(json['message']);
        //                 $('#table-data').DataTable().ajax.reload();
        //             } else {
        //                 alert(json['message']);
        //             }
        //         }
        //     })
        // }
    })

    function remove(t) {
        $(t).parent().parent().remove();
        totalOrder();
    }

    function totalOrder() {
        var sub_amount = 0;
        $('.sub-total').each(function(){
            sub_amount = sub_amount + parseFloat($(this).text());
        })
        $('.total-amount').text(sub_amount.toFixed(2));
    }

    function checkProduct() {
        var c = 0;
        $('.qty').each(function(){
            c = c + parseInt($(this).val());
        })

        return (c > 0) ? true : false;
    }
</script>