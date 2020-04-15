$(function () {
    $("#feedback-tab a").click(function () {
        $("#userFeedbackDlg").modal("show");
    });
    $("#mqr-tab a").click(function () {
        $("#mqrDlg").modal("show");
    });
    $("#rental-mqr-tab a").click(function () {
        $("#rentalMQRDlg").modal("show");
    });
    $(".feedback-form").on('submit', function (event) {
        var $form = $(this);
        $('#feedback-spinner').removeClass('hide');
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function (data) {
                $('#feedback-spinner').addClass('hide');
                $("#feedback-response").html(data.response);
            }
        });
        event.preventDefault();
    });
});

