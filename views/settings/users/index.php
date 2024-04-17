<?php
include('../../../inc/app_settings.php');
require_once('../../../inc/helpers.php');
require_once('../../../models/User_roles.php');
define('PAGE_TITLE', 'Users');

$helpers = new Helpers();
$userRoles = new User_roles();

if(!$helpers->checkSession()) {
    $helpers->redirectLogin();
    return;
}
include_once '../../../templates/header.php';
include_once '../../../templates/sidebar.php';

$resUserRoles = $userRoles->getWhere();
?>
<style>
    .password-area {
        display: none;
    }
</style>
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
                                    First Name
                                </th>
                                <th>Last Name</th>
                                <th>User Name</th>
                                <th>User Role</th>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" autocomplete = "off" data-parsley-required=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" autocomplete = "off" data-parsley-required=""/>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="User Name" autocomplete = "off" data-parsley-required=""/>
                    </div>
                    <div class="row password-area" id="password-area">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="*******" autocomplete = "off" data-parsley-required=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="*******" data-parsley-equalto="#password" autocomplete = "off" data-parsley-required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select name="user_role" id="user_role" class="form-control" data-parsley-required="">
                            <option value="">Select</option>
                            <?php foreach($resUserRoles as $userRole): ?>
                                <option value="<?php echo $userRole['id'] ?>" class="">
                                    <?php echo $userRole['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                url: '<?php echo BASE_URL ?>/api/settings/users/get.php',
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
                "targets": [6],
                "orderable": false
            } ],
            "order": []
        });

        $('#btn-add').click(function(){
            $('#frm-common')[0].reset();
            $('.modal-title').html('Add User');
            $('#action_type').val('add');
            $('#password-area').removeClass('password-area');
            $('#id').val('');
            $('#first_name').val('');
            $('#last_name').val('');
            $('#user_name').val('');
            $('#user_role').val('');

            $('#password').attr('data-parsley-required', true);
            $('#confirm_password').attr('data-parsley-required', true);
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
                    url : '<?php echo BASE_URL ?>/api/settings/users/dml.php',
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
        $('#frm-common')[0].reset();
        $('.modal-title').html('Edit User');
        $('#action_type').val('update');
        $('#id').val($(this).data('id'));
        $('#first_name').val($(this).data('first-name'));
        $('#last_name').val($(this).data('last-name'));
        $('#user_name').val($(this).data('user-name'));
        $('#user_role').val($(this).data('user-role'));
        
        $('#password-area').addClass('password-area');

        $('#password').removeAttr('data-parsley-required');
            $('#confirm_password').removeAttr('data-parsley-required');

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
        var name = $(this).data('first-name') + ' ' + $(this).data('last-name');

        if(confirm('Are you sure you want delete user: ' + name + '?'))
        {
            $.ajax({
                url : '<?php echo BASE_URL ?>/api/settings/users/dml.php',
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