<div class="wp-block-columns alignwide FAQ">
    <div class='wp-block-column'>
        <?php
        if (have_rows('faq')) :
            while (have_rows('faq')) : the_row();
                $question = get_sub_field('question');
                $answer = get_sub_field('answer');
                ?><details itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <summary itemprop="name" class='summary question'> <p><?php echo $question; ?></p> </summary>
                    <div itemscope itemprop="acceptedAnswer" class='answer' itemtype="https://schema.org/Answer">
                        <div itemprop="text">
                            <?php echo $answer; ?>
                        </div>
                    </div>
                </details><?php
            endwhile;
        endif;
        ?>
    </div>

    <script>
        let allFaqs = document.querySelectorAll('.FAQ details');
        allFaqs.forEach(faq => {
            faq.addEventListener('click', (event) => {
                allFaqs.forEach(function (block) {
                    if (block !== faq) {
                        block.removeAttribute('open');
                    }
                });
            })
        });
    </script>

</div>
