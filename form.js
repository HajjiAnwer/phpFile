$(function () {
    $("form['registration']").validate({
        rules: {
            joketext: "required",
        },
        messages: {
            joketext: "Please specify your joke",
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
})