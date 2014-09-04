<?php 

/**
 * Page template
 *
 */
 $redirect = $page->relate_page->url;
 $url = $redirect;
 $session->redirect($url);
?>