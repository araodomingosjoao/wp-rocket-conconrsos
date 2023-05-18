jQuery.ajax({
    type: 'POST',
    url: ajaxurl,
    data: {
        action: 'validate_answer',
        resposta_respondida: "A",
    },
    success: function(response) {
        console.log("resp: ", response);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("error: ", XMLHttpRequest, textStatus, errorThrown);
    }
});
