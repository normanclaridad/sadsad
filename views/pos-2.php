<?php
include('../inc/app_settings.php');
require_once('../inc/helpers.php');
require_once('../models/Prices.php');

$prices = new Prices();
$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}

include_once '../templates/header.php';
// include_once 'templates/sidebar.php';

$resProducts = $prices->getProductsWithPrice("p.status = 'Y'", "p.name ASC");

?>
<style>
    #main{
        margin-left: 0px;
    }

    .table>:not(caption)>*>*{
        font-size: 13px;
    }
    #card-title-order{
        padding: 0px;
    }

    table.tbl-products tfoot {
        position: sticky;
    }
    table.tbl-products tfoot {
        inset-block-end: 0; /* "bottom" */
    }

    .cust-view {
        background-color: #f1f1aa !important;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transactions                       
                            <span class="float-end">
                                <a class="btn btn-sm btn-primary" id="btn-add">
                                    <i class="ri-add-circle-line"></i>
                                </a>
                            </span>
                        </h5>
                        <table class="table datatable" id="table-data">
                            <thead>
                            <tr>
                                <th>Transaction No</th>
                                <th>
                                    Customer Name
                                </th>
                                <th>
                                    Total Amount
                                </th>
                                <th>Amount Paid</th>
                                <th>Change</th>
                                <th>Status</th>
                                <th>Transaction Date/Time</th>
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
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <form method="post" id="frm-products" data-parsley-validate="">
                            <h5 class="card-title" id="card-title-order" style="text-align: left;">Products</h5>
                            <div class="form-group">
                                <label>Product</label>
                                <select name="product_id" id="product_id" style="width: 100%;" data-parsley-required="" data-parsley-errors-container="#product-id-error">
                                    <option value="">Select Product</option>
                                    <?php foreach($resProducts as $product): ?>
                                        <option value="<?php echo $product['id'] ?>" data-product-name="<?php echo $product['product_name'] ?>" data-selling-price="<?php echo $product['selling_price'] ?>" data-unit="<?php echo $product['unit_name'] ?>" data-unit-id="<?php echo $product['unit_id'] ?>" data-product-id="<?php echo $product['product_id'] ?>">
                                            <?php echo $product['product_name'] ?>
                                            |
                                            <?php echo $product['unit_name'] ?>
                                            |
                                            Stock: <?php echo ($product['quantity'] - $product['purchase']); ?>
                                            |
                                            Price: <?php echo number_format($product['selling_price'],2) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="product-id-error"></div>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="product-name" class="form-control" readonly>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <input type="text" id="unit" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" id="price" class="form-control text-end" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" id="quantity" class="form-control" data-parsley-required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="text" id="amount" class="form-control text-end" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <br>
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-add-order">
                                            <i class="bi bi-plus-circle"></i>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <form id="frm-orders" data-parsley-validate="">
                            <h5 class="card-title" id="card-title-order" style="text-align: center;">Orders</h5>
                            <input type="hidden" id="action_type" name="action_type" value="add">
                            <div class="error-message">
                            </div>
                            <div style="border-left: 1px solid #ccc; height: 300px;">
                                <table class="table table-responsive" id="tbl-products">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">TOTAL</th>
                                            <th class="total-order text-end"></th>
                                            <th>&nbsp;</th>
                                    </tfoot>
                                </table>
                            </div>
                            <div style="border-left: 1px solid #ccc;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Name:</label><input type="text" id="customer_name" name="customer_name" value="Customer" style="width: 100%;" />
                                    </div>
                                    <div class="col-md-4">
                                        Cash:
                                        <input type="text" id="cash" name="cash" class="text-end" style="width: 100%;"" data-parsley-required=""/>
                                    </div>
                                    <div class="col-md-4">
                                        Change:
                                        <input type="text" id="change" name="change" class="text-end" style="width: 100%;"" readonly/>
                                    </div>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
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
                url: '<?php echo BASE_URL ?>/api/get-pos.php',
                type: 'POST',
                data:   function ( d ) {
                    return $.extend( {}, d, {
                        // 'action' : getAction()
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
                "targets": [7],
                "orderable": false
            } ],
            "order": []
        });

        $('#product_id').select2({
            placeholder: 'Select an option',
            dropdownParent: $('.modal')
        });

        $('#btn-save').click(function()
        {
            
            if(!checkProduct()){
                alert('Please add an order!');
                return;
            }

            var orders = [];
            $('.ordered-product').each(function(){
                var order = {}
                    // id : $(this).parent().parent().data('id'),
                    // price : $(this).parent().parent().data('price'),
                    // quantity : $(this).parent().parent().find('td').eq(1).find('input').val()
                // };
                // orders.push(order);

                order.id = $(this).data('id');
                order.price = $(this).data('price');
                order.unit_id = $(this).data('unit-id');
                order.product_id = $(this).data('product-id');
                order.quantity = $(this).find('td').eq(1).find('input').val();
                orders.push(order);
            })

            var formData = {
                action_type : $('#action_type').val(),
                customer_name : $('#customer_name').val(),
                cash : $('#cash').val(),
                change : $('#change').val(),
                total_amount : $('.total-order').text()
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
                    url : '<?php echo BASE_URL ?>/api/pos.php',
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
            var cash = $(this).maskMoney('unmasked')[0];;
            var amount = $('.total-order').text();
                // cash.replace(/,/ig, '');
                console.log(cash, amount);
            var change = parseFloat(cash) - parseFloat(amount);

            $('#change').val(change.toFixed(2));
            
        })
        $('#btn-add').click(function(){
            $('.modal-title').html('New Transaction');
            $('#action_type').val('add');
            $('#id').val('');
            $('#product_id').val('');
            $('#product_id').trigger('change.select2');
            $('#unit_id').val('');
            $('#unit_id').trigger('change.select2');
            $('#quantity').val('');
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
    
    $(document).on('keyup', '.qty-order', function(){
        // console.log();
        var quantity = $(this).val();

        var price = $(this).parent().parent().data('price');
        var amount = parseFloat(quantity) * parseFloat(price);

        $(this).parent().parent().find('td').eq(4).text(amount.toFixed(2));
        totalOrder();
    });

    $(document).on('click', '.qty-order', function(){
        $(this).trigger('keyup');
    });

    
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
        $('.sub-amount').each(function(){
            sub_amount = sub_amount + parseFloat($(this).text());
        })
        $('.total-order').text(sub_amount.toFixed(2));
    }

    function checkProduct() {
        var c = 0;
        $('.ordered-product').each(function(){
            c++;
        })

        return (c > 0) ? true : false;
    }
</script>