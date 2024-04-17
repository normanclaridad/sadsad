<?php
include('../../../inc/app_settings.php');
require_once('../../../inc/helpers.php');
require_once('../../../models/Suppliers.php');
require_once('../../../models/Products.php');
require_once('../../../models/Units.php');
require_once('../../../models/Events.php');

$helpers = new Helpers();
$suppliers = new Suppliers();
$products = new Products();
$units = new Units();
$events = new Events();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
include_once '../../../templates/header.php';
include_once '../../../templates/sidebar.php';

$resSuppliers = $suppliers->getWhere(" WHERE status != 'D'", "name ASC");
$resProducts = $products->getWhere(" WHERE status != 'D'", "name ASC");
$resUnits = $units->getWhere(" WHERE status != 'D'", "name ASC");
$resEvents = $events->getWhere(" WHERE status != 'D'", "name ASC");
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Stocks</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active">Stocks</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stocks                       
                            <span class="float-end">
                                <select name="event" id="event">
                                    <option value="">Select Event</option>
                                    <?php foreach($resEvents as $event): ?>
                                        <option value="<?php echo $event['id'] ?>">
                                            <?php echo $event['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <a class="btn btn-sm btn-primary" id="btn-add">
                                    <i class="ri-add-circle-line"></i>
                                </a>
                            </span>
                        </h5>
                        <table class="table datatable" id="table-data">
                            <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>
                                    <b>N</b>ame
                                </th>
                                <th>
                                    Unit
                                </th>
                                <th>Quantity</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm-products" data-parsley-validate="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="action_type" name="action_type" value="add">
                    <div class="error-message">
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control" data-parsley-required="" style="width: 100%;" data-parsley-errors-container="#supplier-id-error">
                            <option value="">Select Supplier</option>
                            <?php foreach($resSuppliers as $supplier): ?>
                                <option value="<?php echo $supplier['id'] ?>">
                                    <?php echo $supplier['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="supplier-id-error"></div>
                    </div>
                    <div class="form-group">
                        <label>Product</label>
                        <select name="product_id" id="product_id" class="form-control" data-parsley-required="" style="width: 100%;" data-parsley-errors-container="#product-id-error">
                            <option value="">Select Product</option>
                            <?php foreach($resProducts as $row): ?>
                                <option value="<?php echo $row['id'] ?>">
                                    <?php echo $row['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="product-id-error"></div>
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control" data-parsley-required="" style="width: 100%;" data-parsley-errors-container="#unit-id-error">
                            <option value="">Select Unit</option>
                            <?php foreach($resUnits as $unit): ?>
                                <option value="<?php echo $unit['id'] ?>">
                                    <?php echo $unit['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="unit-id-error"></div>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" id="quantity" class="form-control text-end" data-parsley-required="" data-parsley-errors-container="#quantity-error" placeholder="0.0" autocomplete = "off"/>
                        <div id="quantity-error"></div>
                    </div>
                    <br>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="status" name="status">
                      <label class="form-check-label" for="status">
                        Status
                      </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- End Vertically centered Modal-->
<?php
    include_once '../../../templates/footer.php';
?>

<script>
    $(document).ready(function(){

        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo BASE_URL ?>/api/settings/stocks/get.php',
                type: 'POST',
                data:   function ( d ) {
                    return $.extend( {}, d, {
                        // 'action' : getAction()
                        'event_id' : $('#event option:selected').val()
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
                "targets": [5],
                "orderable": false
            } ],
            "order": []
        });
        
        $("#event").change(function (e) {
            table.ajax.reload();
        });

        $('#product_id').select2({
            placeholder: 'Select an option',
            dropdownParent: $('.modal')
        });

        $('#unit_id').select2({
            dropdownParent: $('.modal')
        });

        $('#btn-add').click(function(){
            $('.modal-title').html('Add Stocks');
            $('#action_type').val('add');
            $('#id').val('');
            $('#product_id').val('');
            $('#product_id').trigger('change.select2');
            $('#unit_id').val('');
            $('#unit_id').trigger('change.select2');
            $('#quantity').val('');
            $('#products').modal('show');
        })

        $('#btn-save').click(function()
        {
            if(!$('form#frm-products').parsley().validate()) {
                return;
            }
            
            var msg = $('.error-message');

            if(confirm('Are all data is correct?')){ 
                $.ajax({
                    url : '<?php echo BASE_URL ?>/api/settings/stocks/dml.php',
                    type : 'post',
                    data : $('#frm-products').serialize(),
                    success : function(data) {
                        var json = $.parseJSON(data);
                        alert(json['message']);
                        if(json['code'] == 0) {
                            $('#products').modal('hide');
                            table.ajax.reload();
                            // location.reload();
                        }
                    }
                })
            }
            return false;
        })
    })

    //Bind to edit
    $(document).on('click', 'a.btn-edit', function(){
        $('.modal-title').html('Edit Product');
        $('#action_type').val('update');
        $('#id').val($(this).data('id'));        
        $('#supplier_id').val($(this).data('supplier-id'));
        // $('#supplier_id').trigger('change.select2');
        $('#product_id').val($(this).data('product-id'));
        $('#product_id').trigger('change.select2');
        $('#unit_id').val($(this).data('unit-id'));
        $('#unit_id').trigger('change.select2');
        $('#quantity').val($(this).data('quantity'));
        $('#status').removeAttr('checked');
        $('#status').removeAttr('checked');
        if($(this).data('status') == 'Y'){
            $('#status').attr('checked', true);
        }
        $('.error-message').html('');

        //Show modal
        $('#products').modal('show');
    });

    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete user: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/settings/product-prices/dml.php',
                type : 'post',
                data : { action_type : 'delete', 'id' : id },
                success : function(data) {
                    var json = $.parseJSON(data);
                    if(json['code'] == 0) {
                        alert(json['message']);
                        $('#table-data').DataTable().ajax.reload();
                    } else {
                        alert(json['message']);
                    }
                }
            })
        }
    })
</script>