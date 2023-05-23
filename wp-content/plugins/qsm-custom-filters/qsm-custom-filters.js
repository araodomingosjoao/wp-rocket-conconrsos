jQuery(document).ready(function($) {

    // Filtrar perguntas com base na pesquisa e categoria selecionada
    function filterQuestions() {
        var searchQuery = $('#qsm-custom-search').val().toLowerCase();
        var categoryId = $('#qsm-custom-category').val();

        $('.qsm-question-wrapper').each(function() {
            var question = $(this).text().toLowerCase();
            var categoryClass = 'category-section-id-c' + categoryId;

            if ((searchQuery === '' || question.indexOf(searchQuery) !== -1) &&
                (categoryId === '' || $(this).hasClass(categoryClass))) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#qsm-custom-search, #qsm-custom-category').on('change keyup', function() {
        filterQuestions();
    });

});
