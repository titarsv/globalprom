<?php
	
	function wptuts_scripts_basic() 
	{
        //wp_deregister_script('jquery'); // выключаем стандартный jquery
        wp_enqueue_script('vendor',  str_replace('blog/wp-content/themes/responsivetheme','',get_template_directory_uri()).'/assets/js/vendors.js','','',true);
        wp_enqueue_script('app',  str_replace('blog/wp-content/themes/responsivetheme','',get_template_directory_uri()).'/app.js',array('vendor'),'',true);

//	    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', [], false, 1);
//	    wp_enqueue_script('jquery');

	    // wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js', ['jquery'], false, 1);  
	    // wp_enqueue_script('jquery-ui');  
	
//	    wp_register_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', ['jquery'], false, 1);
//	    wp_enqueue_script('bootstrap');

//	    wp_register_script('script', get_template_directory_uri() . '/js/script.js', ['jquery'], false, true);
//	    wp_enqueue_script('script');
//
	    wp_register_script('callme', '/callme/js/callme.js', ['jquery'], false, true);
	    wp_enqueue_script('callme');
	}  

	add_action( 'wp_enqueue_scripts', 'wptuts_scripts_basic' );	

	function wptuts_styles_with_the_lot()  
	{  
//	    wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
//	    wp_enqueue_style( 'bootstrap' );

//	    wp_register_style('blog-style', get_stylesheet_uri());
	    wp_register_style('blog-style',  str_replace('blog/wp-content/themes/responsivetheme','',get_template_directory_uri()).'/assets/css/application.css');
	    wp_enqueue_style( 'blog-style');

//	    wp_register_style( 'fontello', get_template_directory_uri() . '/css/fontello.css');
//	    wp_enqueue_style( 'fontello' );
	}  
	add_action( 'wp_enqueue_scripts', 'wptuts_styles_with_the_lot' );

	if (function_exists('add_theme_support')) {
		add_theme_support('menus');
	}

	add_theme_support( 'post-thumbnails' );

	function true_register_wp_sidebars() {
	 
		/* В боковой колонке - первый сайдбар */
		register_sidebar(
			array(
				'id' => 'true_side', // уникальный id
				'name' => 'Боковая колонка', // название сайдбара
				'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
				'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
				'after_widget' => '</div>',
				'before_title' => '<p class="widget-title">', // по умолчанию заголовки виджетов в <h2>
				'after_title' => '</p>'
			)
		);
	 
		/* В подвале - второй сайдбар */
		register_sidebar(
			array(
				'id' => 'true_foot',
				'name' => 'Футер',
				'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
				'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			)
		);
	}
	 
	add_action( 'widgets_init', 'true_register_wp_sidebars' );

	add_filter( 'the_content_more_link', '__return_empty_string' );

	add_filter('navigation_markup_template', 'my_navigation_template', 10, 2 );
	function my_navigation_template( $template, $class ){
		/*
		Вид базового шаблона:
		<nav class="navigation %1$s" role="navigation">
			<h2 class="screen-reader-text">%2$s</h2>
			<div class="nav-links">%3$s</div>
		</nav>
		*/

		return '
		<nav class="navigation %1$s" role="navigation">
			<div class="nav-links">%3$s</div>
		</nav>    
		';
	}

    function the_domain(){
        echo str_replace(array('http://', '/blog'),array('https://', ''),get_option('siteurl'));
    }

    function get_all_cats(){
        global $wpdb;
        $root_cats = $wpdb->get_results("select id, name, url_alias, status from `categories` where `parent_id` = '0' and `status` = '1' and `categories`.`deleted_at` is null order by `sort_order` asc");
        $root_ids = array();
        foreach($root_cats as $i => $cat){
            $root_ids[] = $cat->id;
            $root_cats[$i]->children = array();
        }
        $subcats = $wpdb->get_results("select id, name, url_alias, parent_id, status from `categories` where `categories`.`parent_id` in (".implode(',',$root_ids).") and `categories`.`deleted_at` is null");
        $subcats_ids = array();
        foreach($subcats as $cat){
            $subcats_ids[] = $cat->id;
            foreach($root_cats as $i => $rcat){
                if($rcat->id == $cat->parent_id && $cat->status){
                    $root_cats[$i]->children[] = $cat;
                    break;
                }
            }
        }
        unset($subcats);
        $chidrencats = $wpdb->get_results("select id, name, url_alias, parent_id, status from `categories` where `categories`.`parent_id` in (".implode(',',$subcats_ids).") and `categories`.`deleted_at` is null");
        foreach($root_cats as $fi => $cat){
            foreach($cat->children as $i => $subcat){
                $root_cats[$fi]->children[$i]->children = array();
                foreach($chidrencats as $cat){
                    if($root_cats[$fi]->children[$i]->id == $cat->parent_id && $cat->status){
                        $root_cats[$fi]->children[$i]->children[] = $cat;
                    }
                }
            }
        }
        unset($chidrencats);

        return $root_cats;
    }
	
	function decrypt($payload, $unserialize = true)
    {
        $payload = getJsonPayload($payload);

        $iv = base64_decode($payload['iv']);

		$cipher = 'AES-256-CBC';
		
		$key = base64_decode('Cc9WmQ2zYl50cnN15NyEtFC9IQq2967M2iMDxHVxOQU=');
		
        // Here we will decrypt the value. If we are able to successfully decrypt it
        // we will then unserialize it and return it out to the caller. If we are
        // unable to decrypt this value we will throw out an exception message.
        $decrypted = \openssl_decrypt(
            $payload['value'], $cipher, $key, 0, $iv
        );

        if ($decrypted === false) {
            echo 'Could not decrypt the data.';
        }

        return $unserialize ? unserialize($decrypted) : $decrypted;
    }
	
	function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);

        // If the payload is not valid JSON or does not have the proper keys set we will
        // assume it is invalid and bail out of the routine since we will not be able
        // to decrypt the given value. We'll also check the MAC for this encryption.
        if (! validPayload($payload)) {
            echo 'The payload is invalid.';
        }

        if (! validMac($payload)) {
			echo 'The MAC is invalid.';
        }

        return $payload;
    }
	
	function validPayload($payload)
    {
        return is_array($payload) && isset(
            $payload['iv'], $payload['value'], $payload['mac']
        );
    }

    function validMac(array $payload)
    {
        $calculated = calculateMac($payload, $bytes = random_bytes(16));

        return hash_equals(
            hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated
        );
    }
	
	function calculateMac($payload, $bytes)
    {
        return hash_hmac(
            'sha256', myhash($payload['iv'], $payload['value']), $bytes, true
        );
    }
	
	function myhash($iv, $value)
    {
		$key = base64_decode('Cc9WmQ2zYl50cnN15NyEtFC9IQq2967M2iMDxHVxOQU=');
		
        return hash_hmac('sha256', $iv.$value, $key);
    }

?>