<?php
/*
 * Footer
 * Description: Common Footer Template
 * Author: Vernyll Jan P. Asis
 */
?>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../bower_components/chart.js/Chart.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script>
  $(document).on('click', '#admin_profile', function(e){
    e.preventDefault();
    $('#profile').modal('show');
    var user_id = $(this).data('user_id');
    var firstname = $(this).data('firstname');
    var lastname = $(this).data('lastname');
    var middlename = $(this).data('middlename');
    var address = $(this).data('address');
    var email = $(this).data('email');
    var contact = $(this).data('contact');
    var password = $(this).data('password');

    $('#user_id').val(user_id)
    $('#firstname').val(firstname)
    $('#lastname').val(lastname)
    $('#middlename').val(middlename)
    $('#address').val(address)
    $('#email').val(email)
    $('#contact').val(contact)
    $('#password').val(password)
  });

  $(function(){
    /** add active class and stay opened when selected */
    var url = window.location;
    
    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

    $('#example1').DataTable({ responsive: true })
    $('#example2').DataTable({ responsive: true })
    $(document).on('click', '.edit', function(e){
      e.preventDefault();
      $('#edit').modal('show');
      var edit_users_id = $(this).data('edit_users_id');
      var edit_type = $(this).data('edit_type');

      $('#edit_users_id').val(edit_users_id)
      $('#edit_type').val(edit_type)
    });
  });
</script>