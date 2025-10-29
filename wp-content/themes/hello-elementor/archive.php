<?php
get_header();
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/posts.css">


<div class="archive-page container">
    <div class="archive-header">
        <h1><?php the_archive_title() ?></h1>
        <p><?php the_archive_description() ?></p>
    </div>
    <?php if (have_posts()): ?>
        <div class="posts">
            <?php while (have_posts()): the_post(); ?>
                <article class="post" id="post-<?php echo the_ID(); ?>" <?php post_class('archive-item') ?>>
                    <div class="post-thumbnail">
                        <img src="<?php the_post_thumbnail_url(); ?>">
                    </div>
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-meta">
                            <span class="tags">
                                <?php echo get_tags()?>
                            </span>
                            <span class="post-date">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 32 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 128C0 92.7 28.7 64 64 64l32 0 0-32c0-17.7 14.3-32 32-32zM64 240l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 368l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z"/></svg>
                                <?php echo get_the_date(); ?></span>
                            <span class="post-author">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 248a120 120 0 1 0 0-240 120 120 0 1 0 0 240zm-29.7 56C95.8 304 16 383.8 16 482.3 16 498.7 29.3 512 45.7 512l356.6 0c16.4 0 29.7-13.3 29.7-29.7 0-98.5-79.8-178.3-178.3-178.3l-59.4 0z"/></svg>
                                <?php the_author_posts_link(); ?></span>
                        </div>

                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <div class="button">
                            <a href="<?php the_permalink() ?>"><span class="button-text">Read more..</span>
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path d="M311.1 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L243.2 256 73.9 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <div class="pagination">
            <?php the_posts_pagination([
                'prev_text' => '« Previous',
                'next_text' => 'Next »',
            ]); ?>
        </div>
    <?php else : ?>
        <p>No posts found in this archive.</p>
    <?php endif; ?>
</div>
<?php
get_footer();
?>