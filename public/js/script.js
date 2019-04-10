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

