$(function(){
    var textButton="<input type='text' name='textfield' id='textfield' class='type-file-text' />  <input type='submit' name='button' id='button' value='浏览' class='type-file-button' />"
    $(textButton).insertBefore("#fileField");
    $("#fileField").change(function(){
        $("#textfield").val($("#fileField").val());
    });
});