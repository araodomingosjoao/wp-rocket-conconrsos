<br>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo __(esc_html(get_admin_page_title()), $this->plugin_name); ?>
    </h1>
    <div class="ays-quiz-how-to-user-custom-fields-box" style="margin: auto;">
        <div class="ays-quiz-how-to-user-custom-fields-title">
            <h4><?php echo __( "Learn How to Use Custom Fields in Quiz Maker", $this->plugin_name ); ?></h4>
        </div>
        <div class="ays-quiz-how-to-user-custom-fields-youtube-video">
            <iframe width="560" height="315" class="ays-quiz-responsive-with-for-iframe" src="https://www.youtube.com/embed/Guq_SncdCMo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
    <div class="row" style="margin:0;">
        <div class="col-sm-12">
            <div class="pro_features pro_features_popup">
                <div class="pro-features-popup-conteiner">
                    <div class="pro-features-popup-title">
                        <?php echo __("Custom Field", $this->plugin_name); ?>
                    </div>
                    <div class="pro-features-popup-content" data-link="https://youtu.be/SEv7ZY7idtE">
                        <p>
                            <?php echo sprintf( __("Custom Fields will allow you to create various fields with %s 8 available field types, %s including text, number, telephone. With just two simple steps, you can get any information you wish from the Quiz takers and add  %s GDPR %s checkbox as well. Get personal data, such as gender, country, age etc.", $this->plugin_name),
                                "<strong>",
                                "</strong>",
                                "<strong>",
                                "</strong>"
                            ); ?>
                        </p>
                        <div>
                            <a href="https://ays-pro.com/wordpress-quiz-maker-user-manual" target="_blank"><?php echo __("See Documentation", $this->plugin_name); ?></a>
                        </div>
                    </div>
                    <div class="pro-features-popup-button" data-link="http://bit.ly/3kpeD2D">
                        <?php echo __("Upgrade PRO NOW", $this->plugin_name); ?>
                    </div>
                </div>
            </div>
            <img src="<?php echo AYS_QUIZ_ADMIN_URL.'/images/attributes_screen.png'?>" alt="Statistics" style="width:100%;" >
        </div>
    </div>

    <div class="ays-modal" id="pro-features-popup-modal">
        <div class="ays-modal-content">
            <!-- Modal Header -->
            <div class="ays-modal-header">
                <span class="ays-close-pro-popup">&times;</span>
                <!-- <h2></h2> -->
            </div>

            <!-- Modal body -->
            <div class="ays-modal-body">
               <div class="row">
                    <div class="col-sm-6 pro-features-popup-modal-left-section">
                    </div>
                    <div class="col-sm-6 pro-features-popup-modal-right-section">
                       <div class="pro-features-popup-modal-right-box">
                            <div class="pro-features-popup-modal-right-box-icon"><i class="ays_fa ays_fa_lock"></i></div>

                            <div class="pro-features-popup-modal-right-box-title"></div>

                            <div class="pro-features-popup-modal-right-box-content"></div>

                            <div class="pro-features-popup-modal-right-box-button">
                                <a href="#" class="pro-features-popup-modal-right-box-link" target="_blank"></a>
                            </div>
                       </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="ays-modal-footer" style="display:none">
            </div>
        </div>
    </div>

</div>