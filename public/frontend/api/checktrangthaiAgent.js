function checktrangthai() {
    setTimeout(function() {
        $.ajax({
            url: "http://127.0.0.1:8000/api/checktrangthaiAgent",
            method: "get",
            success: function(data) {
                alert("có một Agent thiếu hàng");
            }
        });
        checktrangthai();
    }, 5000);
}
