function readURL(input) {
    if (input.files && input.files[0]) {

        let reader = new FileReader();

        reader.onload = function (e) {
            $(input).prev().children().attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".image_input").change(function () {
    readURL(this);
});

$(document).ready(function () {
    $("#contentbox").keyup(function () {
        var box = $(this).val();
        var main = box.length * 100;
        var value = (main / 191);
        var count = 191 - box.length;

        if (box.length <= 191) {
            $('#count').html(count);
            $('#bar').animate(
                {
                    "width": value + '%',
                }, 1);
        }
        else {
            alert(' Full ');
        }
        return false;
    });

});
