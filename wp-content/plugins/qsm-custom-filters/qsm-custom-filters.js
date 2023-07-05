jQuery(document).ready(function ($) {

  var selectedCategories = [];

  $('.js-example-basic-multiple').select2();

  // Filtrar perguntas com base na pesquisa e categoria selecionada
  function filterQuestions() {
    var searchQuery = $('#qsm-custom-search').val().toLowerCase();
    var categoryId = $('#qsm-custom-category').val();

    $('.qsm-question-wrapper').each(function () {
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

  $('#qsm-custom-search, #qsm-custom-category').on('change keyup', function () {
    filterQuestions();
  });

  // Adicionar ícone de comentários após cada pergunta
  $('.qsm-question-wrapper').each(function () {
    var $question = $(this);
    var questionId = $question.data('qid');
    var $commentIcon = $('<p class="qsm-comment-icon"><i class="fas fa-comment-dots"></i> Comentarios</p>');

    $commentIcon.on('click', function () {
      $question.find('.qsm-comment-section').toggle();

      $.ajax({
        url: ajax_object.ajaxurl,
        method: 'POST',
        data: {
          action: 'qsm_get_comments',
          question_id: questionId,
        },
        beforeSend: function () {
          $('.loading-indicator-' + questionId).show();
        },

        success: function (response) {
          var comments = response.data.comments;
          var $commentList = $('.qsm-comment-list' + questionId);
          $commentList.empty();
          comments.forEach(function (comment) {
            var $commentItem = $('<div class="qsm-comment-item">' +
              '<p> Re: ' + comment.comment_text + ' <span class="comment-date">' + comment.created_at + '</span></p>' +
              '</div>');

            $commentList.append($commentItem);
          });

          $('.loading-indicator-' + questionId).hide();
        },
        error: function (error) {
          console.error('Erro ao cadastrar o comentário:', error);
        }
      });
    });
    $question.append($commentIcon);
  });

  $('.qsm-question-wrapper').each(function () {
    var $question = $(this);
    var questionId = $question.data('qid');
    var $commentSection = $('<div class="qsm-comment-section">' +
      '<div class="custom-comment-list">' +
      '<div class="loading-indicator-' + questionId + '">' +
      '<p>Carregando...</p>' +
      '</div>' +
      '<div class="qsm-comment-list' + questionId + '">' +
      '<!-- Aqui serão exibidos os comentários -->' +
      '</div>' +
      '</div>' +
      '<form class="qsm-comment-form">' +
      '<input type="hidden" name="qsm-question-id" value="' + questionId + '">' +
      '<textarea name="qsm-comment-input" rows="3" placeholder="Digite seu comentário"></textarea>' +
      '<button type="submit" class="qsm-comment-submit">Enviar</button>' +
      '</form>' +
      '</div>');

    $question.append($commentSection);
  });

  $('.qsm-comment-form').on('submit', function (e) {
    e.preventDefault();

    var $form = $(this);
    var questionId = $form.find('input[name="qsm-question-id"]').val();
    var comment = $form.find('textarea[name="qsm-comment-input"]').val();

    $.ajax({
      url: ajax_object.ajaxurl,
      method: 'POST',
      data: {
        action: 'qsm_add_comment',
        question_id: questionId,
        comment: comment
      },
      success: function (response) {
        $form.find('textarea[name="qsm-comment-input"]').val('');

        var comments = response.data.comments;
        var $commentList = $('.qsm-comment-list' + questionId);

        $commentList.empty();

        comments.forEach(function (comment) {
          var $commentItem = $('<div class="qsm-comment-item">' +
            '<p> Re: ' + comment.comment_text + ' <span class="comment-date">' + comment.created_at + '</span></p>' +
            '</div>');

          $commentList.append($commentItem);
        });

        console.log($commentList);
      },
      error: function (error) {
        console.error('Erro ao cadastrar o comentário:', error);
      }
    });
  })

  $('#form_filters').submit(function (event) {
    event.preventDefault();
    console.log(selectedCategories);

    var data = {
      action: 'qsm_filters_questions',
      filters: selectedCategories,
    };

    jQuery.ajax(ajax_object.ajaxurl, {
        data: data,
        method: 'POST',
        success: function(response){
          console.log(response);
          parseQuestionData(response.data[0])
        },
        error: function(error){
          console.log(error);
        }
    });
  });

  $('#discipline_ids input[type="checkbox"]').change(function () {
    $('#discipline_ids input[type="checkbox"]:checked').each(function () {
      selectedCategories.push($(this).val());
    });

    // Fazer algo com as categorias selecionadas
    console.log(selectedCategories);
  });

  // Ao clicar em um elemento de categoria
  $('.q-select-input').on('click', function (e) {
    e.stopPropagation(); // Impede que o evento de clique se propague para elementos pai

    // Verificar se o dropdown já está aberto
    var isOpen = $(this).hasClass('open');

    // Fechar todos os dropdowns
    $('.q-select-input').removeClass('open');

    // Abrir ou fechar o dropdown da categoria clicada
    if (!isOpen) {
      $(this).addClass('open');
    }
  });

  // Ao clicar na busca rápida
  $('.q-search-input').on('click', function (e) {
    e.stopPropagation(); // Impede que o evento de clique se propague para elementos pai
  });

  // Ao digitar na busca rápida
  $('#quick-search').on('input', function () {
    var searchValue = $(this).val().toLowerCase();

    // Filtrar os itens de categoria com base no valor da busca
    $('.q-options li').each(function () {
      var itemText = $(this).text().toLowerCase();
      var itemMatches = itemText.indexOf(searchValue) > -1;
      $(this).toggle(itemMatches);
    });
  });

  // Ao clicar em qualquer lugar da página
  $(document).on('click', function () {
    // Fechar todos os dropdowns
    $('.q-select-input').removeClass('open');
  });

  function updateItemCount() {
    var selectedItems = $('input[type="checkbox"]:checked');
    var count = selectedItems.length;

    $('.q-count').text(count  + ' selecionados');
  }

  // Ao clicar em um checkbox
  $('input[type="checkbox"]').on('change', function() {
    updateItemCount();
  });

});

// Função para analisar os dados da pergunta
function parseQuestionData(questionData) {
  var question = {};

  // Extrair o título da pergunta dos question_settings
  var questionSettings = phpUnserialize(questionData.question_settings);
  question.title = questionSettings.question_title;

  // Extrair as respostas do answer_array
  var answers = phpUnserialize(questionData.answer_array);
  console.log(question.title, answers);

  return question;
}

