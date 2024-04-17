<?php
include('../../../inc/app_settings.php');
require_once('../../../inc/helpers.php');
define('PAGE_TITLE', 'Suppliers');
$helpers = new Helpers();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
include_once '../../../templates/header.php';
include_once '../../../templates/sidebar.php';
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1><?php echo PAGE_TITLE ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Home</a></li>
          <li class="breadcrumb-item">Settings</li>
          <li class="breadcrumb-item active"><?php echo PAGE_TITLE ?></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo PAGE_TITLE ?>                            
                            <span class="float-end">
                                <a class="btn btn-sm btn-primary" id="btn-add">
                                    <i class="ri-add-circle-line"></i>
                                </a>
                            </span>
                        </h5>
                        <table class="table datatable" id="table-data">
                            <thead>
                            <tr>
                                <th>
                                    <b>N</b>ame
                                </th>
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
<div class="modal fade" id="modal-common" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo PAGE_TITLE ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm-common" data-parsley-validate="">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="action_type" name="action_type" value="add">
                    <div class="error-message">
                    </div>
                    <div class="form-group">
                        <label> Supplier Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Supplier Name" autocomplete = "off" data-parsley-required=""/>
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
                url: '<?php echo BASE_URL ?>/api/settings/suppliers/get.php',
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
                "targets": [3],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-add').click(function(){
            $('.modal-title').html('Add Supplier');
            $('#action_type').val('add');
            $('#id').val('');
            $('#name').val('');
            // $('#description').val('');
            $('#modal-common').modal('show');
        })

        $('#btn-save').click(function()
        {
            if(!$('form#frm-common').parsley().validate()) {
                return;
            }
            
            var msg = $('.error-message');

            if(confirm('Are all data is correct?')){ 
                $.ajax({
                    url : '<?php echo BASE_URL ?>/api/settings/suppliers/dml.php',
                    type : 'post',
                    data : $('#frm-common').serialize(),
                    success : function(data) {
                        var json = $.parseJSON(data);
                        alert(json['message']);
                        if(json['code'] == 0) {
                            $('#modal-common').modal('hide');
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
        $('.modal-title').html('Edit Supplier');
        $('#action_type').val('update');
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        // $('#description').val($(this).data('description'));
        $('#status').removeAttr('checked');
        // $('#status_no').attr('checked', false);
        if($(this).data('status') == 'Y'){
            $('#status').attr('checked', true);
        }
        $('.error-message').html('');

        //Show modal
        $('#modal-common').modal('show');
    });

    $(document).on('click', 'a.btn-delete', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if(confirm('Are you sure you want delete user: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/settings/suppliers/dml.php',
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