function datatableWithAjax(table_id, ajax_route={}, table_column=[], exportButton="", searchInput="",action_after_callback_function=function(oSettings){},action_before_callback_function=function(oSettings){ $("#overlay").show(); }){
    $("#overlay").show();
    setTimeout(() => {
        $('.dt-button').addClass('dt-btn')
        $('.dt-buttons').attr("class", 'dt-buttons btn mt-2')
    }, 1);

    const table = $('#'+table_id).DataTable({
        preDrawCallback: action_before_callback_function,
        processing: true,
        serverSide: true,
        buttons: [
            {
                extend: 'pdf',
                split: ['csv', 'excel'],
            }
        ],
        dom: 'Bfrtilp',
        aaSorting: [],
        ajax: ajax_route,
        columns: table_column,
        fnDrawCallback:action_after_callback_function
    });

    // table.buttons().container().appendTo('#'+exportButton);

    $('#'+searchInput).on('keyup', function () {
        table.search(this.value).draw();
    });

    return table;
}