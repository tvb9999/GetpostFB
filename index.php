<?php
/**
 * Plugin Name: Get Content Facebook
 * Plugin URI: http://hatefb.com
 * Description: Get content all posts on facebook of user, pages, groups.
 * Version: 1.0.1
 * Author: Tang Duong Trieu
 * Author URI: https://www.facebook.com/tangduongtrieu
 * License: GPLv2
 */
?>
<?php
//Register Value
function gcf_register_settings() {
	//Register value for tag Tools
    register_setting( 'gcf-tools', 'gcf_option_id' );
	register_setting( 'gcf-tools', 'gcf_option_type' );
	register_setting( 'gcf-tools', 'gcf_option_token' );
	register_setting( 'gcf-tools', 'gcf_option_cat_parent' );		
	register_setting( 'gcf-tools', 'gcf_option_limit_post' );
	register_setting( 'gcf-tools', 'gcf_option_limit_keyword' );
	register_setting( 'gcf-tools', 'gcf_option_limit_post_char' );
	register_setting( 'gcf-tools', 'gcf_option_limit_comment' );
	register_setting( 'gcf-tools', 'gcf_option_limit_comment_char' );
	register_setting( 'gcf-tools', 'gcf_option_total_like' );
	//Register value for tag Setting
	register_setting( 'gcf-settings', 'gcf_option_cron' );	
	register_setting( 'gcf-settings', 'gcf_option_single_likes');
	register_setting( 'gcf-settings', 'gcf_option_single_attach');
	register_setting( 'gcf-settings', 'gcf_option_single_view');
	register_setting( 'gcf-settings', 'gcf_option_single_avata');
	register_setting( 'gcf-settings', 'gcf_option_single_comments');
	register_setting( 'gcf-settings', 'gcf_option_single_images');
}
//Create Menu GCF
function gcf_create_menu() {
    add_menu_page('Get Content Facebook Settings', 'GCF', 'administrator', __FILE__, 'gcf_settings_page',plugins_url('/images/icon.png', __FILE__), 71);
    add_action( 'admin_init', 'gcf_register_settings' );
}
add_action('admin_menu', 'gcf_create_menu');
function gcf_settings_page() {
//Set active for Tab
if(isset($_GET['tab'])) {
	$active_tab = wp_unslash( $_GET['tab'] );
}
else {
	$active_tab = 'tools';
}
?>
<div class="wrap">
	<h2>Get Content Facebook Setting.</h2>
	<h2 class="nav-tab-wrapper">  
	<a href="?page=get-content-facebook%2Findex.php&tab=tools" class="nav-tab <?php echo $active_tab == 'tools' ? 'nav-tab-active' : ''; ?>"><span class="dashicons dashicons-admin-tools"></span> Tools</a>  
	<a href="?page=get-content-facebook%2Findex.php&tab=setting" class="nav-tab <?php echo $active_tab == 'setting' ? 'nav-tab-active' : ''; ?>"><span class="dashicons dashicons-admin-generic"></span> Setting</a>
	</h2>
<?php
//TAB Tools
if(empty($_GET['tab']) || wp_unslash( $_GET['tab'] == "tools" )){
	if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'edit_files' ) ) {
		exit();
	}
?>
<form method="post" action="options.php">
    <?php settings_fields( 'gcf-tools' ); ?>
    <table class="form-table">
        <tr><th scope="row">ID</th>
			<td><input type="text" class="regular-text"  placeholder="ID Facebook (Pages, Groups, Users)" name="gcf_option_id" value="" required/>
			<label class="description"><a href="javascript:void(0)" id="wtf-id" style='text-decoration: none;'>!?</a></label>
			<p style="display:none" id="tip-id" class="description">
			Step 1: Go to <a target="_Blank" href="https://findmyfbid.in/">findmyfbid.in</a></br>
			Step 2: Copy url Facebook and paste</br>
			Step 3: Copy UID and paste here.</br>
			Ex:
			Url: fb.com/zuck => 4</p>
			</td>
		</tr>		
		<tr><th scope="row">Type</th>
			<td><select name="gcf_option_type" style="width: 10em;">
				<option selected="selected" value="Pages">Pages</option>
				<option value="Groups">Groups</option>
				<option value="User">User</option>
			</select>
			<label class="description"><a href="javascript:void(0)" id="wtf-type" style='text-decoration: none;'>!?</a></label>
			<p style="display:none" id="tip-type" class="description">
			Ex:</br>
			Url: fb.com/zuck => User</br>
			Url: fb.com/bbcnews => Pages</br>
			Url: fb.com/groups/grouptinhte/ => Groups</p>
			</td>
		</tr>		
		<tr><th scope="row">Token</th>
			<td><input type="text" class="regular-text"  placeholder="User Token Facebook" name="gcf_option_token" value="<?php echo $token = get_option('gcf_option_token'); ?>" required/>
			<label class="description"><a href="javascript:void(0)" id="wtf-token" style='text-decoration: none;'>!?</a></label>
			<p style="display:none" id="tip-token" class="description">
			Step 1: Go to <a target="_Black" href="http://fb.com/me">fb.com/me</a></br>
			Step 2: "Ctrl + U".</br>
			Step 3: "Ctrl + F" and Find "access_token".</br>
			Step 4: Copy token Facebook and paste here.</br>
			Ex: EAAAAUaZA8jlABALWtTh51e9vY6EbD7...</p>
			</td>
		</tr>
		<tr><th scope="row">Parent Category:</th>
			<td><?php wp_dropdown_categories('hide_empty=0&show_count=1&hierarchical=1&name=gcf_option_cat_parent'); ?></td>
		</tr>
    </table>
	<div style="padding: 15px 0;">
		<div style="font-size:18px;font-weight: 600;float: left;padding-right:15px;"><span class="dashicons dashicons-awards"></span> Advanced For Pro</div>
		<div style="float: left;"><a href="javascript:void(0)" style='text-decoration: none;' id="show_hide"><span class="dashicons dashicons-visibility"></span> Show/Hide</a></div>
	</div>	
	<table id="advanced" class="form-table" style="display:none">		
		<tr><th scope="row">Limit scan Post:</th>
        <td><input type="number" class="small-text" name="gcf_option_limit_post" min='100' value="<?php echo $token = get_option('gcf_option_limit_post', 500); ?>" required/>
		<p class="description">Limit total posts on feed allow scan.</p>
		</td></tr>		
		<tr><th scope="row">Keywords:</th>
        <td><input type="text" class="regular-text" placeholder="Apple, Samsung, Sony" name="gcf_option_limit_keyword" value="" />
		<p class="description">Only get content if keyword found.</p>
		</td></tr>		
		<tr><th scope="row">Character Content:</th>
        <td><input type="number" class="small-text" name="gcf_option_limit_post_char" value="<?php echo $token = get_option('gcf_option_limit_post_char', 50); ?>" required/>
		<p class="description">Only get content if total characters more.</p>
		</td></tr>
		<tr><th scope="row">Limit scan Comment:</th>
        <td><input type="number" class="small-text" name="gcf_option_limit_comment" value="<?php echo $token = get_option('gcf_option_limit_comment', 50); ?>" required/>
		<p class="description">Limit total comments on post allow scan.</p>
		</td></tr>
		<tr><th scope="row">Character in Comment:</th>
        <td><input type="number" class="small-text" name="gcf_option_limit_comment_char" value="<?php echo $token = get_option('gcf_option_limit_comment_char', 10); ?>" required/>
		<p class="description">Only get comment if total characters more.</p>
		</td></tr>
		<tr><th scope="row">Total Likes</th>
        <td><input type="number" class="small-text" name="gcf_option_total_like" value="<?php echo $token = get_option('gcf_option_total_like', 10); ?>" required/>
		<p class="description">Only get content if total likes more.</p>
		</td></tr>
	</table>
<?php submit_button(); ?>
</form>
</div>
<?php
if(isset($_POST) && isset($_GET['settings-updated'])) {
	if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'edit_files' ) ) {
		exit();
	}
	add_option('gcf_array_id', array());
	$number_post = ( int ) get_option('gcf_option_limit_post');	
	$keyword = esc_html( get_option('gcf_option_limit_keyword') );	
	$character_content = ( int ) get_option('gcf_option_limit_post_char');
	$number_comment = ( int ) get_option('gcf_option_limit_comment');
	$character_comment = ( int ) get_option('gcf_option_limit_comment_char');	
	$total_like = ( int ) get_option('gcf_option_total_like');	
	$cat_parent = ( int ) get_option('gcf_option_cat_parent');
	$pageid = ( int ) get_option('gcf_option_id');
	add_option("gcf_option_$pageid", 0);
	$type = esc_html( get_option('gcf_option_type') );	
	$token = esc_html( get_option('gcf_option_token') );	
	$check_token = esc_html( GCF_Check_Token($token) );
	$check_name = esc_html( GCF_Name_Page($pageid, $token) );
	$check_privacy = esc_html( GCF_Check_Privacy($pageid, $token) );
	if(empty($check_token)){
		echo "<div class='notice notice-error'><p>Error ! Your TOKEN not working.</p></div>";
		goto _exit;
	}	
	if(!empty($check_token) && empty($check_name)){	
		echo "<div class='notice notice-error'><p>Error ! Your ID is false.</p></div>";
		goto _exit;
	}
	if(!empty($check_privacy)){	
		echo "<div class='notice notice-error'><p>Groups is Closed, Please buy PRO Version!</p></div>";
		goto _exit;
	}
	//Parent Category
	if(empty($cat_parent) || $cat_parent === '1'){
		$category = array (wp_create_category($check_name));
		}
	else{
		$category_chil = wp_create_category($check_name, $cat_parent);
		$category = array ($category_chil, $cat_parent);
	}
	$date = date('Y-m-d H:i:s');
	$old_options = get_option( 'gcf_array_id', array() );	
	$count = count($old_options);	//Count Item in Array
	$old_options[$pageid] = array( 'name' => $check_name, 'type' => $type, 'date' => $date, 'category' => $category, 'number_post' => $number_post, 'character_content' => $character_content, 'number_comment' => $number_comment, 'character_comment' => $character_comment, 'total_like' => $total_like, 'keyword' => $keyword, 'process' => '0', );
	if(!empty($pageid) && !empty($type) && !empty($check_name)){
		update_option('gcf_array_id', $old_options);	//Update Array
		wp_clear_scheduled_hook('gcf_time_action_hook');	//Remove scheduled_hook
		echo "<div id='message' class='updated'><p><strong>Saved</strong></p></div>";
	}
_exit:
}
?>
<div class="wrap">
<?php
echo "<div id='test' style='font-size:15px;font-weight:600;padding-bottom:15px;'>Limit 10 pages</div>"; ?>
<div id="gcf-box">
<table class="widefat striped">
<thead>
	<tr>
		<th scope="col">Name</th>
		<th scope="col">Progress</th>
		<th scope="col">Action</th>
	</tr>
</thead>
<tbody>
	<?php
	$old_options = get_option( 'gcf_array_id', array() );
	$old_options = array_reverse($old_options, true);
	$check_cron = esc_html(get_option('gcf_option_cron'));
	if(empty($check_cron)){$check_cron = "Never";}
	foreach ($old_options as $pageid => $data ) {	
		$pageid = ( int ) $pageid;
		$category = get_category($data['category'][0]);
		$count = $category->category_count;
		echo "<tr class='pageid' id='$pageid'>
		<td class='open'>
		<span style='cursor: pointer;' class='dashicons dashicons-arrow-down'></span>
		<a rel='nofollow' href='".get_home_url()."?cat=".esc_html($data['category'][0])."'>".esc_html($data['name'])." (<span id='count_$pageid'>".$count."</span>)</a>
		</td>
		<td><span id='process_$pageid'>".( int )get_option("gcf_option_$pageid")."</span>/".esc_html($data['number_post'])."</td>
		<td><a href='javascript:void(0)' onclick='click_ajax($pageid);process_ajax($pageid)'><span class='dashicons dashicons-controls-play'></span> Scan</a> | <a href='javascript:void(0)' onclick='click_remove($pageid)'><span class='dashicons dashicons-trash'></span> Remove</a></td>
		</tr>
		<tr class='content'>
		<td>
		<p>ID: ".( int ) $pageid."</p>
		<p>Created: ".esc_html($data['date'])."</p>		
		<p>Parent Category: ".esc_html(get_cat_name($data['category'][1]))."</p>
		<p>Category: ".esc_html(get_cat_name($data['category'][0]))."</p>
		<p>Type: ".esc_html($data['type'])."</p>		
		<p>Limit scan Comment: ".esc_html(( int ) $data['number_comment'])."</p>		
		<p>Character Content: ".esc_html(( int ) $data['character_content'])."</p>		
		<p>Character in Comment: ".esc_html( ( int ) $data['character_comment'])."</p>		
		<p>Total Likes: ".esc_html( ( int ) $data['total_like'])."</p>
		<p>Keywords: ".esc_html( $data['keyword'])."</p>
		</td>
		</tr>";
	}
	?>
</tbody>
</table>
</div>
</div>
<?php }	//Close Get tools ?>
<?php if(isset($_GET['tab']) &&  wp_unslash( $_GET['tab']== "setting" )) { 
if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'edit_files' ) ) {
	exit();
}
?>
<form method="post" action="options.php">
    <?php settings_fields( 'gcf-settings' ); ?>
    <table class="form-table">
		<tr><th scope="row">Auto Scan: </th>
        <td><select name="gcf_option_cron" style="width: 10em;">			
			<option value="hourly" <?php if(get_option('gcf_option_cron', 0)=='hourly') echo 'selected'; ?> >Hourly</option>
			<option value="twicedaily" <?php if(get_option('gcf_option_cron', 0)=='twicedaily') echo 'selected'; ?> >Twicedaily</option>			
			<option value="daily" <?php if(get_option('gcf_option_cron', 0)=='daily') echo 'selected'; ?> >Daily</option>
			<option value="" <?php if(!get_option('gcf_option_cron', 0)) echo 'selected'; ?> >Never</option>
		</select></td></tr>
		<tr><th scope="row">Create Thumbnail: </th>
        <td><input type="checkbox" name="gcf_option_single_images" value="1" <?php checked(1, get_option('gcf_option_single_images', 1)) ?> /><label>Create thumbnail with image on post of Facebook.</label>
		</td></tr>
		<tr><th scope="row">Display Images: </th>
        <td><input type="checkbox" name="gcf_option_single_attach" value="1" <?php checked(1, get_option('gcf_option_single_attach', 1)) ?> /><label>Display thumbnail on post.</label>
		</td></tr>
		<tr><th scope="row">Scan comments: </th>
        <td><input type="checkbox" name="gcf_option_single_comments" value="1" <?php checked(1, get_option('gcf_option_single_comments', 1)) ?> /><label>If uncheck only posts content without comment.</label>
		</td></tr>
		<tr><th scope="row">Change Avatar: </th>
        <td><input type="checkbox" name="gcf_option_single_avata" value="1" <?php checked(1, get_option('gcf_option_single_avata', 0)) ?> /><label>On box comment change avatar default with avatar Facebook.</label>
		</td></tr>
        <tr><th scope="row">Display Likes: </th>
        <td><input type="checkbox" name="gcf_option_single_likes" value="1" <?php checked(1, get_option('gcf_option_single_likes', 1)) ?> /><label>Display total likes on post.</label>
		</td></tr>
		<tr><th scope="row">Link to Facebook: </th>
        <td><input type="checkbox" name="gcf_option_single_view" value="1" <?php checked(1, get_option('gcf_option_single_view', 1)) ?> /><label>Display link to Facebook on post.</label>
		</td></tr>		
	</table>
    <?php submit_button(); ?>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
//Remove Id Page in array
function GCF_Remove_ID($pageid) {
		$old_options = get_option('gcf_array_id', array());
		unset($old_options[$pageid] );
		update_option('gcf_array_id', $old_options);
	}
//Check Token
function GCF_Check_Token($token){
	$urlcheck= "https://graph.facebook.com/me?access_token=$token";
	$getcheck = json_decode(wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $urlcheck ) )), true ) ;
	$name = $getcheck['name'];
	return $name;
}
//Get Name Page From UID.
function GCF_Name_Page($pageid, $token){
	$urlcheck= "https://graph.facebook.com/$pageid?access_token=$token";
	$getcheck = json_decode(wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $urlcheck ) )), true ) ;
	$name = $getcheck['name'];
	return $name;
}
//Check Privacy UID.
function GCF_Check_Privacy($pageid, $token){
	$urlcheck= "https://graph.facebook.com/$pageid?access_token=$token";
	$getcheck = json_decode(wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $urlcheck ) )), true ) ;
	if(isset($getcheck['privacy'])){$privacy = $getcheck['privacy'];}else{$privacy ="";}
	if(!empty($privacy) && $privacy == 'CLOSED'){
	return $privacy;}
}
//Run auto get content.
$schedules = get_option('gcf_option_cron');
if(!empty($schedules)){	
	if (!wp_next_scheduled('gcf_time_action_hook')) {
		wp_schedule_event( time(), $schedules, 'gcf_time_action_hook' );
	}
	add_action('gcf_time_action_hook', 'gcf_scraph_cron');
}
//Scraph Facebook Cron
function gcf_scraph_cron(){	
	$old_options = get_option( 'gcf_array_id', array() );
	$token = get_option('gcf_option_token');
	if(function_exists('fastcgi_finish_request')){
		session_write_close();
		fastcgi_finish_request();
		}
	else{
		ob_end_flush();
		flush();
	}
	foreach ($old_options as $pageid => $data ) {
		$pageid = ( int ) $pageid;
		update_option("gcf_option_$pageid", 0);
		$type = $data['type'];
		$keyword = $data['keyword'];
		$idcate = $data['category'];		
		$number_post = $data['number_post'];		
		$character_content = $data['character_content'];
		$number_comment = $data['number_comment'];
		$character_comment = $data['character_comment'];
		$total_like = $data['total_like'];
		$typescraph = GCF_Type_Scraph($type);
		$url = "https://graph.facebook.com/v2.10/".$pageid."/".$typescraph."?fields=id,full_picture,source,created_time,message,type,link,likes&limit=50&access_token=".$token;
		$i = 0;
		while(isset($url) & $i < 1){
				$get = json_decode(wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $url ) )), true ) ;
				$url = $get['paging']['next'];
				GCF_Insert_Post($get, $pageid, $idcate, $token, $character_content, $number_comment, $character_comment, $total_like, $keyword, $number_post);
				$i++;
			}
	}
}
//Scraph Facebook All
function GCF_Graph_All($pageid){
		//Get Array Value	
		$old_options = get_option( 'gcf_array_id', array());
		$token = get_option('gcf_option_token');
		$keyword = $old_options[$pageid]['keyword'];
		$type = $old_options[$pageid]['type'];
		$idcate = $old_options[$pageid]['category'];	
		$number_post = $old_options[$pageid]['number_post'];
		$character_content = $old_options[$pageid]['character_content'];
		$number_comment = $old_options[$pageid]['number_comment'];
		$character_comment = $old_options[$pageid]['character_comment'];
		$total_like = $old_options[$pageid]['total_like'];
		$typescraph = GCF_Type_Scraph($type);
		$url = "https://graph.facebook.com/v2.10/".$pageid."/".$typescraph."?fields=id,full_picture,source,created_time,message,type,link,likes&limit=100&access_token=".$token;
		$i = 1;
		while(isset($url) & $i <= ($number_post/100)){
			$get = json_decode(wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $url ) )), true ) ;
			$url = $get['paging']['next'];
			GCF_Insert_Post($get, $pageid, $idcate, $token, $character_content, $number_comment, $character_comment, $total_like, $keyword, $number_post);
			$i++;		
		}
}
//Get type scraph
function GCF_Type_Scraph($type){
	if($type === "Pages"){
		$typescraph = "posts";
		}
	elseif($type === "Groups" || $type === "User"){
		$typescraph = "feed";
		}
	return $typescraph;
}
//Insert Post
function GCF_Insert_Post($get, $pageid, $idcate, $token, $character_content, $number_comment, $character_comment, $total_like, $keyword, $number_post){
	foreach ($get['data'] as $value){				
				$postid = $value['id'];
				if(isset($value['message'])){$message = $value['message'];}else{$message ="";}
				$message = preg_replace('#https?://#', '', $message);
				$message = preg_replace('#www.?#', '', $message);				
				$created_time=$value['created_time'];
				if(isset($value['full_picture'])){$full_picture = $value['full_picture'];}else{$full_picture ="";}
				if(isset($value['likes']['count'])){$likes = $value['likes']['count'];}else{$likes ="";}
				$type = $value['type'];
				if(isset($value['source'])){$source = $value['source'];}else{$source ="";}
				$title = GCF_Filter_Title($message);
				if(isset($value['link'])){$urlvideo = $value['link'];}else{$urlvideo ="";}
				//IF type photo
				if($type == "photo"){		
					$urlphoto = "https://graph.facebook.com/v2.10/".$postid."?fields=attachments{subattachments{media{image{src}}}}&access_token=".$token;
					$getphoto = json_decode(wp_remote_retrieve_body(wp_remote_get( $urlphoto ) ), true );
					//$getphoto = json_decode(file_get_contents($urlphoto), true);
					foreach ($getphoto['attachments']['data'][0]['subattachments']['data'] as $valuephoto){							
						$multi_pic .= $valuephoto['media']['image']['src']."|";
					}
				}
				//Check duplicate	
				$post_id = gcf_get_post_id('post_id_fb', $postid);
				$post_tit = get_page_by_title($Ctitle,'OBJECT','post');
				$check_pos = GCF_Get_Keyword($message, $keyword);
				if(empty($post_id) && empty($post_tit) && !empty($title) && strlen($message) >= $character_content && $likes >= $total_like && $check_pos > 0){
					// Create post object
					$my_post = array(
						'post_title'   => esc_html($title),
						'post_content' => esc_html($message),
						'post_date' => $created_time,
						'post_status'  => 'publish',
						'post_author'   => 1,
						'post_category' => $idcate,
						'meta_input'   => array('post_id_fb' => esc_html ( $postid ), 'post_likes_fb' => (int) $likes, 'post_picture_fb' => esc_url_raw ( $full_picture ), 'post_type_fb' => esc_html( $type ), 'post_type_multi_pic_fb' => esc_html ( $multi_pic ), 'post_video_fb' => esc_url_raw ( $urlvideo ), 'post_source_fb' => esc_url_raw ( $source) , )
						);
					// Insert the post into the database
					$post_id = wp_insert_post($my_post);					
					$tag = GCF_Add_Tag($message);
					wp_set_post_tags($post_id, esc_html($tag));
					//Create thumbnail
					if(get_option('gcf_option_single_images', 1) == 1 && !empty($full_picture)){						
						GCF_Creating_Thumbnail($full_picture, $post_id, $message, $type);
					}
					//Scan comments
					if(get_option("gcf_option_single_comments", 1) == 1 && $number_comment > 0){
						GCF_Scraph_Comments($postid, $token, $post_id, $number_comment, $character_comment);
					}
				}
			$pageid = ( int ) $pageid;			
			$process = ( int ) (get_option("gcf_option_$pageid") + 1);
			if($process > $number_post){$process = 0;}
			update_option("gcf_option_$pageid", $process);
			unset($multi_pic, $message, $title, $full_picture, $my_post, $source);
			}
}
//Get Images on Site
function GCF_Get_Image_Image($full_picture){
	if(strpos($full_picture, 'safe_image.php'))	{
			$full_picture = explode('url=' , $full_picture);
			$full_picture = explode('&' , $full_picture[1]);
			$full_picture = $full_picture[0];
			$full_picture = urldecode($full_picture);
		}
	return $full_picture;
}
//Creating Thumbnail
function GCF_Creating_Thumbnail($image_url, $post_id, $message, $type){
    $upload_dir = wp_upload_dir();
	if($type == 'link'){
		$image_url = GCF_Get_Image_Image($image_url);
		}    
	if (getimagesize($image_url) !== false) {
		$image_data = file_get_contents($image_url);
		$message = strtolower(GCF_Remove_Symbol(GCF_Remove_Unicode($message)));
		$str = trim(mb_substr($message, 0, 20), '-');
		$rand = GCF_Generate_Random_String(6);
		$filename = $str.$rand.".jpg";		
		if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
		else                                    $file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);
		$wp_filetype = wp_check_filetype($filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
		$res2= set_post_thumbnail( $post_id, $attach_id );
	}
}
//Scraph Comments Facebook
function GCF_Scraph_Comments($postid, $token, $post_id, $number_comment, $character_comment){
	$url = "https://graph.facebook.com/v2.10/".$postid."/comments?fields=id,created_time,from,message,parent&limit=".$number_comment."&access_token=".$token;	
	$get = json_decode(wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $url ) )), true ) ;
	foreach ($get['data'] as $value)
	{
		$created_time = $value['created_time'];		
		$message = $value['message'];
		$message = preg_replace('#https?://#', '', $message);
		$message = preg_replace('#www.?#', '', $message);
		$name = $value['from']['name'];	
		$id = $value['from']['id'];
		$idcomments = $value['id'];
		if(isset($value['parent']['id'])){$parent = $value['parent']['id'];}else{$parent ="";}
		$data = array(
			'comment_post_ID' => (int) $post_id,
			'comment_author' => esc_html($name),
			'comment_author_email' => '',
			'comment_author_url' => 'https://facebook.com/'.$id,
			'comment_content' => esc_html($message),
			'comment_type' => '',
			'comment_parent' => 0,
			'user_id' => 0,
			'comment_author_IP' => '127.0.0.1',
			'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
			'comment_date' => $created_time,
			'comment_approved' => 1,
		);
		if(strlen($message)>=$character_comment && empty($parent)){
			//Insert comments to database
			$comment_id = wp_insert_comment($data);
			add_comment_meta( (int) $comment_id, 'meta_id_facebook', esc_html ( $idcomments ) );	
		}
	}
}
//Get keyword
function GCF_Get_Keyword($message, $keyword){
	$pos='';
	if(empty($keyword)){
		$pos = '1'; 
		return $pos;
	}
	elseif(!stripos($keyword, ',')){
		$message = GCF_Remove_Unicode($message);
		$pos = stripos($message, GCF_Remove_Unicode(trim($keyword)));
		if($pos){return $pos;}
	}
	else{
	$keyword = explode(',', $keyword);
	$i=0;
	$message = GCF_Remove_Unicode($message);
	echo $message."</br>";
		while(isset($keyword[$i]) & !empty($keyword[$i])){				
			$pos = stripos($message, GCF_Remove_Unicode(trim($keyword[$i])));
			if($pos){return $pos;break;}
			$i++;						
		}
	}
}
//Remove Symbol
function GCF_Remove_Symbol($str) {
   $str = str_replace(' ', '-', $str);
   $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
   return preg_replace('/-+/', '-', $str);
}
//Remove Unicode
function GCF_Remove_Unicode($str){
	$unicode = array(
	'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
	'd'=>'đ',
	'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
	'i'=>'í|ì|ỉ|ĩ|ị',
	'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
	'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
	'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
	'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
	'D'=>'Đ',
	'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
	'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
	'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
	'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
	'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	);
	foreach($unicode as $nonUnicode=>$uni){
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
	}
	return $str;
}
//Add Images for Posts
add_filter( 'the_content', 'GCF_Edit_Content' ); 
function GCF_Edit_Content( $content ) { 
    if (is_singular('post')) {
	$multi_pic = get_post_meta(get_the_ID(), 'post_type_multi_pic_fb', true);
	$type = get_post_meta(get_the_ID(), 'post_type_fb', true);
	$thumbnail = get_post_meta(get_the_ID(), 'post_picture_fb', true);
	$urlvideo = get_post_meta(get_the_ID(), 'post_video_fb', true);
	$source = get_post_meta(get_the_ID(), 'post_source_fb', true);
		if(!empty(get_option('gcf_option_single_attach', 1))){			
			if(has_post_thumbnail() && empty($multi_pic) && $type != "video"){
				$thumbnail = get_the_post_thumbnail('', 'full', array( 'class' => 'aligncenter' ));		
				$content = $thumbnail . $content;	
				}
			if (!has_post_thumbnail() && !empty($thumbnail)  && empty($multi_pic) && $type != "video") {				
				$thumbnail = "<img class='aligncenter wp-post-image' src='$thumbnail' class='aligncenter wp-post-image' alt='' srcset='$thumbnail'>";
				$content = $thumbnail . $content;
				}						
			if ( $type == "photo" && !empty($multi_pic)){
				$multi_pic = explode("|", $multi_pic);
				$i=0;
				while(isset($multi_pic[$i]) & !empty($multi_pic[$i])){
					$content = $content . "<div style='text-align: left;position: relative;padding: 0 0px !important;'>	
					<img style='width: 100%;'class='aligncenter wp-post-image' src='$multi_pic[$i]' class='aligncenter wp-post-image' alt='' srcset='$multi_pic[$i]'></div>";
					$i++;
				}
			}
		}		
		if($type == 'video' && strpos($urlvideo, 'facebook') != null){			
			$url = 'https://www.facebook.com/plugins/video/oembed.json/?url='.$urlvideo;
			$check_video = wp_remote_retrieve_body(wp_remote_get( esc_url_raw( $url ) ) ) ;
			if (strpos($check_video, 'author_name') == false){
			$video = "<div style='text-align: center;'><video controls='' poster='$thumbnail' style='padding:10px 0;'>
			<source src='$source' type='video/mp4'>
			</video></div>";			
			}
			else{
			$video = "<div class='facebook-responsive'><iframe src='https://www.facebook.com/plugins/video.php?href=".urlencode($urlvideo)."&show_text=0&height=285' height='285' width='560' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowTransparency='true' allowFullScreen='true'></iframe></div>";			
			}
			$content = $content . $video;
		}
		if($type == 'video' && strpos($source, 'youtu') != null){
			$content = preg_replace('#https?://#', '', $content);
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $source, $matches);
			if (!empty($matches) & strpos($source, 'youtu') !== false) {$id = $matches[1];}
			$video = "<div style='text-align: center;'><iframe width='100%' height='400px' src='https://www.youtube.com/embed/".$id."' frameborder='0' allowfullscreen></iframe></div>";
			$content = $content . $video;
		}
		if($type == 'video' && strpos($urlvideo, 'vimeo') != null){
			$id = (int) substr(parse_url($urlvideo, PHP_URL_PATH), 1);
			$video = "<div style='text-align: center;'><iframe src='https://player.vimeo.com/video/".$id."' width='100%' height='400px' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>";
			$content = $content . $video;
		}
		$content = $content . "<div style='font-size:13px;color:#999999;padding:15px 0;'>";
		if(!empty(get_option('gcf_option_single_likes', 1))){
			$likes = get_post_meta(get_the_ID(), 'post_likes_fb', true);	
			$likes = "<span>$likes Likes</span>";
			$content = $content . $likes;
		}
		if(!empty(get_option('gcf_option_single_view', 1))){
			$view = get_post_meta(get_the_ID(), 'post_id_fb', true);	
			$view = "<span><a rel='nofollow' target='_Blank' style='font-size:13px;color:#999999;' href='https://facebook.com/$view'> | View on Facebook</a><span>";
			$content = $content . $view;
		}
		$content = $content . "</div>";		
	}
return $content;
}
//Add Tag
function GCF_Add_Tag($message){
preg_match_all('/#([^039].[\p{L}\p{N}_{&;%}]+)/u', $message, $match);
$value='';$i=0;while(!empty($match[1][$i])){$value .= $match[1][$i].',';$i++;}
return $value;
}
//Filter Title
function GCF_Filter_Title($str){
	//Remove Line
	$str = preg_replace('/\s+/', ' ', $str);
	//Get Title
	$str = trim(mb_substr($str, 0, 90));
	if(strlen($str) >= 40){
		$str = substr($str, 0, strrpos($str, ' '));
	}
	$str = ucfirst($str);
	return $str;
}
//Random String
function GCF_Generate_Random_String($length) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
//Get Post_ID
function gcf_get_post_id($key, $value) {
	global $wpdb;
	$meta = $wpdb->get_results("SELECT `post_id` FROM `".$wpdb->postmeta."` WHERE meta_key='".esc_sql($key)."' AND meta_value='".esc_sql($value)."';");
	if (is_array($meta) && !empty($meta) && isset($meta[0])) {
		$meta = $meta[0];
		}	
	if (is_object($meta)) {
		return $meta->post_id;
		}
	else {
		return false;
		}
}
//Add Avata Facebook Comments
if (!function_exists('get_avatar') && get_option('gcf_option_single_avata', 0) == 1) {
	add_filter( 'get_avatar', array( $this, 'get_avatar' ), 10, 5 );

function get_avatar( $avatar, $id_or_email='', $size='', $default='', $alt='' ){
	$urlcm = get_comment_author_url();
	if(strpos($urlcm, 'facebook')!=null){
		$urlcm = preg_replace('#^https?://#', '', $urlcm);	
		$avatar = "<img src='https://i2.wp.com/graph.$urlcm/picture?d=".urlencode($default)."&s=".$size."' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		return $avatar;
	}
	else{
		$avatar = "<img src='http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		return $avatar;
	}
}
}
//Get
function gcf_scan_ajax_function(){ 
echo "<script>
var pageid;
function click_ajax(pageid){
    (function($){
        var data = {
            'action': 'gcf_scan_ajax',
            'pageid': pageid
        };
        $.post(ajaxurl, data, function(response){
        });
    })(jQuery);
}
function process_ajax(pageid){
(function($){
        var data = {
            'action': 'gcf_scan_ajax',
            'process': pageid
        };
        $.post(ajaxurl, data, function(response){
			response = response.slice(0, -1);
			$('#process_' + pageid).html(response);			
        });
})(jQuery);
}
function click_remove(pageid){
(function($){
        var data = {
            'action': 'gcf_scan_ajax',
            'remove': pageid
        };
        $.post(ajaxurl, data, function(response){			$('#'+pageid).next().hide();
			$('#'+pageid).hide();			
        });
})(jQuery);
}
</script>";
}
add_action('admin_footer', 'gcf_scan_ajax_function');
function gcf_process_scan(){	
	if(isset($_POST['pageid'])){	
		if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'edit_files' ) ) {
			exit();
		}
		$pageid = ( int ) wp_unslash( $_POST['pageid']);
		update_option("gcf_option_$pageid", 0);
		echo $pageid;
		if(function_exists('fastcgi_finish_request')){
			session_write_close();
			fastcgi_finish_request();
		}
		else{
			ob_end_flush();
			flush();
		}
		GCF_Graph_All($pageid);
		die();
	}
	elseif(isset($_POST['process'])){
		if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'edit_files' ) ) {
			exit();
		}
		$pageid = wp_unslash( $_POST['process']);
		$process = get_option("gcf_option_$pageid");
		echo $process;
		sleep(1);
		echo "<script>
		(function($){
        var data = {
            'action': 'gcf_scan_ajax',
            'process': $pageid
        };
        $.post(ajaxurl, data, function(response){
			response = response.slice(0, -1);
			$('#process_' + $pageid).html(response);			
        });
		})(jQuery);
		</script>";
	}
	elseif(isset($_POST['remove'])){
		if ( ! current_user_can( 'manage_options' ) ||  ! current_user_can( 'edit_files' ) ) {
			exit();
		}
		$pageid = wp_unslash( $_POST['remove']);
		delete_option("gcf_option_$pageid");
		GCF_Remove_ID($pageid);
	}
}
add_action('wp_ajax_gcf_scan_ajax', 'gcf_process_scan');
function gcf_plugin_admin_script() {
    wp_enqueue_script( 'plugin-script-gcf', plugins_url( '/js/gcf.js', __FILE__ ) );
}
add_action( 'admin_init', 'gcf_plugin_admin_script' );
function gcf_styles(){
    wp_enqueue_style( 'plugin-style_gcf', plugins_url( '/css/gcf.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'gcf_styles' );
?>