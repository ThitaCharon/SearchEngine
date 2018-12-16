$(function () {
    $('.result').on('click',function ()
    {
        let url = $(this).attr('href');
        let id = $(this).attr('data-linkId');
        if (!id){
            alert("no id");
        }
        updateClick(id,url);
        return false;
    });
});


function updateClick(id, url) {
$.post('../../ajax/updatelinkCount.php',{id:id});
}