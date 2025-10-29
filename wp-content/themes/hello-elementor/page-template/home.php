<?php

/**
 * Template Name: Archive Page
 */
get_header();
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/posts.css">
<script>
    jQuery(document).ready(function() {
        jQuery("form").on("submit", handleChange); // pass a function reference
    });
    function handleChange(e) {
            e.preventDefault();
            let category_id = jQuery(this).find("#category").val().trim();
            let tag_id = jQuery(this).find("#post_tag").val().trim();
            let category = jQuery(this).find("#category option:selected").text().trim();
            let tag = jQuery(this).find("#post_tag option:selected").text().trim();
 
            let posts_count = parseInt(jQuery(this).find("#posts_count").val(), 10) || 0//returns the first truthy value whereas ?? will return the first value that is not null or undefined;
            let term = "";

            if (category_id.length > 0 && (!tag_id || tag_id === "")) {
                term = category;
                tag_id = 0;
            } else if (category_id.length > 0) {
                term = category + " x " + tag;
            } else if (category_id.length === 0 && tag_id.trim().length > 0) {
                term = tag;
                category_id = 0;
            }
            /*jQuery.ajax({
                url:'<?php echo admin_url("admin-ajax.php"); ?>',
                type:'POST',
                data:{
                    action:'load_posts',
                    term_id:term_id,
                    taxonomy: taxonomy,
                    nonce: '<?php echo wp_create_nonce("ajax_posts_nonce"); ?>'
                },  
                success: function(response){
                    if(response.success){
                        let html='';
                        console.log(response.data);
                        response.data.forEach(function(post){
                            html=`<li><a href="${post.link}">${post.title}</a></li>`;
                        });

                        jQuery("#dynamic-content").html(html);
                    }
                    else{
                        jQuery("#dynamic-content").html(`<p>${response.data}</p>`);

                    }
                }
            })*/

            const xhr = new XMLHttpRequest();
            const url = '<?php echo admin_url("admin-ajax.php"); ?>';
            const data = new URLSearchParams({
                action: 'load_posts',
                tag_id: tag_id,
                category_id: category_id,
                count: posts_count,
                nonce: '<?php echo wp_create_nonce("ajax_posts_nonce"); ?>'
            });
            xhr.open('POST', url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (this.status == 200) {
                    console.log(xhr.responseText);
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        let html = `<h2 class="archive-title">${term}</h2><div class="posts">`;
                        response.data.forEach(
                            function(post) {
                                html += `
                            <article class="post" id="post-${post.id}" <?php post_class('archive-item') ?>>
                                <div class="post-thumbnail">
                                    ${post.thumbnail}
                                </div>
                                <div class="post-content">
                                    <h2 class="post-title">
                                        <a href="${post.link}">${post.title}</a>
                                    </h2>
                                    <div class="post-meta">
                                        <span class="post-date">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 32 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 128C0 92.7 28.7 64 64 64l32 0 0-32c0-17.7 14.3-32 32-32zM64 240l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 368l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z"/></svg>
                                        ${post.date}</span>
                                        <span class="post-author">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 248a120 120 0 1 0 0-240 120 120 0 1 0 0 240zm-29.7 56C95.8 304 16 383.8 16 482.3 16 498.7 29.3 512 45.7 512l356.6 0c16.4 0 29.7-13.3 29.7-29.7 0-98.5-79.8-178.3-178.3-178.3l-59.4 0z"/></svg>
                                            ${post.author}
                                        </span>
                                    </div>

                                    <div class="post-excerpt">
                                        ${post.excerpt}
                                    </div>
                                    <div class="button">
                                        <a href="${post.link}"><span class="button-text">Read more..</span>
                                            <span class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                    <path d="M311.1 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L243.2 256 73.9 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </article>`;
                            });
                        html += '</div>'

                        jQuery("#dynamic-content").html(html);
                    } else {
                        jQuery("#dynamic-content").html(`<p>${response.data}</p>`);
                    }
                } else {
                    jQuery("#dynamic-content").html(`<p>${xhrr.status}</p>`);
                }
            }

            xhr.send(data.toString());

        }
    
</script>

<?php
$categories = get_categories(array(
    'number' => 0,      // get all categories
    'hide_empty' => false // include categories even if they have no posts
));

$tags = get_tags(array(
    'number' => 0,      // get all categories
    'hide_empty' => false // include categories even if they have no posts
));


$output = '<div class="taxonomy-page container">
                <form>
                    <label for="category">Category: </label>
                    <select name="category" id="category">
                        <option value="">Select a category</option>';
foreach ($categories as $category) {
    $output .= '
                        <option value="' . $category->term_id . '">
                            ' . esc_html($category->name) . '
                        </option>';
}
$output .= '
                    </select>

                    <label for="post_tag">Tag: </label>
                    <select name="post_tag" id="post_tag">
                        <option value="">Select a tag</option>';
foreach ($tags as $tag) {
    $output .= '
                        <option value="' . $tag->term_id . '">' .
        esc_html($tag->name)
        . '</option>';
}
$output .= '
                    </select>
                    <label for="posts_count">No. of posts</label>
                    <input type="number" name="posts_count" id="posts_count" min="0">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>';

$output .= "<div id='dynamic-content' class='container'></div>";

echo $output;
?>

<?php
get_footer();
