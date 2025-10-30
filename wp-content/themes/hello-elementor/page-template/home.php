<?php
/**
 * Template Name: Archive Page
 */
get_header();
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/posts.css">

<script>
jQuery(document).ready(function() {
    // Use 'change' for select and 'input' for number field
    jQuery("#category, #post_tag").on("change", handleChange);
    jQuery("#posts_count").on("input", handleChange);

    // Prevent form submit
    jQuery("form").on("submit", e => e.preventDefault());
});

function handleChange(e) {
    const form = jQuery(this).closest("form");
    e.preventDefault();

    let category_id = jQuery(form).find("#category").val().trim();
    let tag_id = jQuery(form).find("#post_tag").val().trim();
    let category = jQuery(form).find("#category option:selected").text().trim();
    let tag = jQuery(form).find("#post_tag option:selected").text().trim();
    let posts_count = parseInt(jQuery(form).find("#posts_count").val(), 10) || 0;

    let term = "All Posts";

    if (category_id.length > 0 && (!tag_id || tag_id === "")) {
        term = category;
        tag_id = 0;
    } else if (category_id.length > 0) {
        term = category + " x " + tag;
    } else if (category_id.length === 0 && tag_id.trim().length > 0) {
        term = tag;
        category_id = 0;
    }

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
        let html = `<h2 class="archive-title">${term}</h2>`;

        if (this.status == 200) {
            console.log(xhr.responseText);
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                html += `<div class="posts">`;

                response.data.forEach(function(post) {
                    html += `
                        <article class="post archive-item" id="post-${post.id}">
                            <div class="post-thumbnail">
                                ${post.thumbnail}
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span class="post-date">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 32 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 128C0 92.7 28.7 64 64 64l32 0 0-32c0-17.7 14.3-32 32-32zM64 240l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 368l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z"/>
                                        </svg>
                                        ${post.date}
                                    </span>
                                    <span class="post-author">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path d="M224 248a120 120 0 1 0 0-240 120 120 0 1 0 0 240zm-29.7 56C95.8 304 16 383.8 16 482.3 16 498.7 29.3 512 45.7 512l356.6 0c16.4 0 29.7-13.3 29.7-29.7 0-98.5-79.8-178.3-178.3-178.3l-59.4 0z"/>
                                        </svg>
                                        ${post.author}
                                    </span>
                                </div>
                                <div class="post-excerpt">${post.excerpt}</div>
                                <div class="button">
                                    <a href="${post.link}">
                                        <span class="button-text">Read more..</span>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                <path d="M311.1 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L243.2 256 73.9 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </article>`;
                });

                html += `</div>`;
            } else {
                html += `<p>${response.data}</p>`;
            }
        } else {
            html += `<p>${xhr.status}</p>`;
        }

        jQuery("#dynamic-content").html(html);
    }

    xhr.send(data.toString());
}
</script>

<?php
$categories = get_categories();
$tags = get_tags();

$output = '<div class="taxonomy-page container">
    <form>
        <div class="form-container">
            <div class="input-fields">
                <label for="category">Category: </label>
                <select name="category" id="category">
                    <option value="">Select a category</option>';
                        foreach ($categories as $category) {
                            $output .= '<option value="' . $category->term_id . '">' . esc_html($category->name) . '</option>';
                        }
$output .= '      </select>
            </div>

            <div class="input-fields">
                <label for="post_tag">Tag: </label>
                <select name="post_tag" id="post_tag">
                    <option value="">Select a tag</option>';
                        foreach ($tags as $tag) {
                            $output .= '<option value="' . $tag->term_id . '">' . esc_html($tag->name) . '</option>';
                        }
$output .= '      </select>
            </div>

            <div class="input-fields">
                <label for="posts_count">No. of posts</label>
                <input type="number" name="posts_count" id="posts_count" min="0">
            </div>
        </div>
    </form>
    <div id="dynamic-content"></div>
</div>';

echo $output;

get_footer();
