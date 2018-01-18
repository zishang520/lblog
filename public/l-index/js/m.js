$(document).ready(function() {
    $('.replay').click(function(event) {
        var nickname = $(this).data('nickname');
        $('#content').val($('#content').val() + '@' + nickname + ' ');
    });
})
