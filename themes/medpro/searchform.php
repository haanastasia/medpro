<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package medpro
 * @version 1.2.0
 * @since 21.01.2026
 */

?>
<form role="search" method="get" id="searchform" class="search col-12 col-lg-auto mb-3 mb-lg-0" action="<?php echo home_url( '/' ) ?>">
    <input class="form-control" type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Поиск по сайту" />
</form>