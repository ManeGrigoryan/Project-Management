function searchResult() {
    document.write(window.location);
}

function searchFunction(id) {
    var search = document.getElementById(id);
    return search;

}
function orderTable(column, formId, orderby, sortby) {
    console.log(column);
    console.log(formId);
    console.log(orderby);
    console.log(sortby);


    document.getElementById('order').value = column;
    if (orderby == 'yes') {
        document.getElementById('sort').value = sortby == 'ASC' ? 'DESC' : 'ASC';
    } else {
        document.getElementById('sort').value = sortby;
    }

    document.getElementById(formId).submit();
}