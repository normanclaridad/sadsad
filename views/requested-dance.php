<?php
include('../inc/app_settings.php');
require_once('../inc/helpers.php');
require_once('../models/Prices.php');
require_once('../models/Events.php');
require_once('../models/Dance_categories.php');

$events = new Events();
$prices = new Prices();
$helpers = new Helpers();
$danceCategories = new Dance_categories();

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

// if(!empty($message)) {
//     echo json_encode(['code' => 5, 'message' => $message]);
//     return;
// }

$eventId = (count($resEvents) == 1) ? $resEvents[0]['id'] : 0;

include_once '../templates/header.php';
include_once '../templates/sidebar.php';

// $where = " WHERE status = 'Y' AND event_id = $eventId";

$resDanceCategories = $danceCategories->getWhere("WHERE status = 'Y'", "name ASC");


?>
<style>
    @media(max-width: 767px){
        #main {
            padding: 5px;
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
                        <h5 class="card-title">Requested Dance                       
                            <span class="float-end">
                                <a class="btn btn-sm btn-primary" id="btn-add">
                                    <i class="ri-add-circle-line"></i>
                                </a>
                            </span>
                        </h5>
                        <table class="table datatable" id="table-data">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>
                                    Total
                                </th>
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
                <form id="frm-orders" data-parsley-validate="">
                    <input type="hidden" id="action_type" name="action_type" value="add">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="error-message">
                    </div>
                    <div class="form-group">
                        <label for="">Dance Category</label>
                        <select name="dance_category_id" id="dance_category_id" class="form-control" data-parsley-required="">
                            <option value="">Select</option>
                            <?php foreach($resDanceCategories as $danceCategory): ?>
                                <option value="<?php echo $danceCategory['id'] ?>">
                                    <?php echo $danceCategory['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="name" name="name" data-parsley-required="" />
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="text" class="form-control text-end" id="amount" name="amount" data-parsley-required="" />
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

<div class="modal fade" id="modal-delete" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 13px 5px 17px;">
                <h5 class="modal-title-delete">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm-delete" data-parsley-validate="">
                    <input type="hidden" id="action_type_del" name="action_type" value="delete">
                    <input type="hidden" id="id_del" name="id" value="">
                    <div class="error-message">
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="name_del" name="name" data-parsley-required="" readonly />
                    </div>
                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="text" class="form-control text-end" id="amount_del" name="amount" readonly data-parsley-required="" />
                    </div>
                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" data-parsley-required=""></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-delete-record">Delete</button>
            </div>
        </div>
    </div>
</div><!-- End Vertically centered Modal-->

<?php
    include_once '../templates/footer.php';
?>
<script>
    $(document).ready(function(){

        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo BASE_URL ?>/api/get-requested-dance.php',
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
                "targets": [3],
                "orderable": false
            } ],
            "order": []
        });
        $('#amount').maskMoney();
        $('#btn-save').click(function(){

            if(!$('form#frm-orders').parsley().validate()) {
                return;
            }

            var msg = $('.error-message');

            if(confirm('Are all data is correct?')){ 

                $.ajax({
                    url : '<?php echo BASE_URL ?>/api/requested-dance.php',
                    type : 'post',
                    data : $('#frm-orders').serialize(),
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

        $('#btn-delete-record').click(function(){
            if(!$('form#frm-delete').parsley().validate()) {
                return;
            }

            var msg = $('.error-message');

            if(confirm('Are you sure you want to delele this record?')){ 

                $.ajax({
                    url : '<?php echo BASE_URL ?>/api/requested-dance.php',
                    type : 'post',
                    data : $('#frm-delete').serialize(),
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
            <?php if(empty($resEvents)) { ?>
                alert('<?php echo $message ?>');
                return;
            <?php } ?>
            $('.modal-title').html('New Transaction');
            $('#action_type').val('add');
            $('#dance_category_id').val('');
            $('#name').val('');
            $('#amount').val('');
            $('#products').modal('show');
        })

    })
    
    $(document).on('click', 'a.btn-edit', function(){
        $('.modal-title').text('Edit');
        var id = $(this).data('id');
        $('#id').val($(this).data('id'));
        $('#action_type').val('update');
        $('#dance_category_id').val($(this).data('dance-category-id'));
        $('#name').val($(this).data('name'));
        $('#amount').val($(this).data('amount'));
        $('#products').modal('show');
    });
    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        // var transaction_no = $(this).data('transaction-no');
        $('#id_del').val($(this).data('id'));
        $('#name_del').val($(this).data('name'));
        $('#amount_del').val($(this).data('amount'));
        $('#modal-delete').modal('show');
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