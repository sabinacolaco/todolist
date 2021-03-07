$(document).ready(function() {
    var url = SITE_URL+'ajaxprocess.php';
    $('.datetimepicker').datetimepicker({  
        minDate:new Date()
    });

    $("#addform").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            beforeSend: function () {
                $('.submitBtn').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
            success: function(result) {
                if (result == 1) {
                    $(".modal-body").html("<div class='alert alert-success' role='alert'>Thank you, your task has been added.</div>");
                    setTimeout(function() {
                    window.location.href = SITE_URL;
                    }, 3000);
                }
                else if (result == 2) {
                    $('#error').text('Please enter the task');
                }
                $('.submitBtn').removeAttr("disabled");
                $('.modal-body').css('opacity', '');
            }
        });
    });
    
    $('#editModal').on('show.bs.modal', function(e){
        var taskId = $(e.relatedTarget).data('id');
        $(".modal-body #hdnedittaskId").val( taskId );
        $.ajax
        ({
            type: "GET",
            url: url+'?edittaskId='+ taskId,
            cache: false,
            success: function(result)
            {
                var obj = JSON.parse(result);
                
                $(".modal-body #hdnedittaskId").val( obj.id );
                $(".modal-body #inputTask").val( obj.task );
                $(".modal-body #inputDuedate").val( obj.due_date );
            
            } 
        });
    });

    $("#editform").submit(function(e) {            
        e.preventDefault();
        var form = $(this);
        var taskId = $("#hdnedittaskId").val();
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data){
                if (data == 1) {
                    $(".modal-body").html("<div class='alert alert-success' role='alert'>Thank you, your task has been edited.</div>");
                    setTimeout(function() {
                    window.location.href = SITE_URL;
                    }, 3000);
                }
            }
        });
    });
     
    $('#deleteModal').on('shown.bs.modal', function (e) {
        var taskId = $(e.relatedTarget).data('id');
        $(".modal-body #hdntaskId").val( taskId );
    })

    $('.modal-footer').on('click', '.delete', function() {
        var taskId = $("#hdntaskId").val();
            $.ajax({
              url: url+'?deltaskId='+ taskId,
              cache: false,
              success:function(result){
                 //$('#deleteModal').modal('hide');
                 $(".modal-body").html("<div class='alert alert-success' role='alert'>Thank you, your task has been deleted.</div>");
                 setTimeout(function() {
                 window.location.href = SITE_URL;
                 }, 3000);
            }
        });
    
    });
    
    $('#rescheduleModal').on('show.bs.modal', function(e){
        var taskId = $(e.relatedTarget).data('id');
        $(".modal-body #hdnedittaskId").val( taskId );
        $.ajax
        ({
            type: "GET",
            url: url+'?edittaskId='+ taskId,
            cache: false,
            success: function(result)
            {
                var obj = JSON.parse(result);
                
                $(".modal-body #hdnedittaskId").val( obj.id );
                $(".modal-body #inputTask").val( obj.task );
                $(".modal-body #inputDuedate").val( obj.due_date );
            
            } 
        });
    });

    $("#rform").submit(function(e) {            
        e.preventDefault();
        var form = $(this);
        var taskId = $("#hdnedittaskId").val();
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data){
                if (data == 1) {
                    $(".modal-body").html("<div class='alert alert-success' role='alert'>Thank you, your task has been rescheduled.</div>");
                    setTimeout(function() {
                    window.location.href = SITE_URL;
                    }, 3000);
                }
            }
        });
    });

});

function markComplete(id) {
    if(id) {
        $.ajax({
             type: "POST",
             url: SITE_URL+'ajaxprocess.php',
             data: {taskId:id, completed:1},
             success: function(data){
                 if(data  == 1){
                    $("#completebtn"+id).addClass('btn-secondary').removeClass('btn-warning');
                 }
             }
        });
    }
}