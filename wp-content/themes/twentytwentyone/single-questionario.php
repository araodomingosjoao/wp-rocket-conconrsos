<?php

$resposta_respondida = "Resposta " . $_POST['resposta'];
$resposta_correcta = the_field('resposta_correcta');

if ($resposta_respondida == $resposta_correcta) {
    echo "Resposta Correcta";
}else{
    echo "Resposta Errada";
}

get_header();

while (have_posts()) {
    the_post();
    ?>
    <h1><?php the_title(); ?></h1>
    <p><?php the_field('pergunta'); ?></p>

    <form action="" method="POST">
        <label for="A">A) <?php the_field('resposta_a'); ?></label>
        <input type="radio" name="resposta" id="A" value="A"> <br>
        <label for="B">B) <?php the_field('resposta_b'); ?></label>
        <input type="radio" name="resposta" id="B" value="B"> <br>
        <label for="C">C) <?php the_field('resposta_c'); ?></label>
        <input type="radio" name="resposta" id="C" value="C"> <br>
        <label for="D">D) <?php the_field('resposta_d'); ?></label>
        <input type="radio" name="resposta" id="D" value="D"> <br><br>

        <button type="submit">Responder</button>
    </form>
    
    <?php
}
get_footer();
?>
