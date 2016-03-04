<?php 
 
/**
 * Page template
 * 
 */
 $redirect = $page->parent->url;
 $url = $redirect;
 $session->redirect($url);
?> 