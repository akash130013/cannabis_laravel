
var sizeArr = [];
var unitArr = [];

addDada = (size, unit, id) => {
    swal({
        title: "Are you sure ?",
        text: "Deleting this, Product added for this size and unit will be deleted in User Panel and Store Panel.",
        type: "error",
        showCancelButton: true,
        cancelButtonClass: 'btn-default btn-md waves-effect',
        confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
        confirmButtonText: localMsg.Delete,
        cancelButtonText: localMsg.Cancel,
        closeOnClickOutside: true,
        closeOnEsc: true
    },
    function (isConfirm) {
        if (isConfirm) {
               sizeArr.push(size);
               unitArr.push(unit);
            $("#"+id).parents(".control-group").remove();
            $("#deleted_size").val(sizeArr);
            $("#deleted_unit").val(unitArr);
        }
    });
  
}