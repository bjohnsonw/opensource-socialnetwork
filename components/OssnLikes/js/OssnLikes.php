/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence 
 * @link      http://www.opensource-socialnetwork.org/licence
 */
Ossn.ViewLikes = function($post, $type){
                      if(!$type){
                        $type = 'post';
                      }
                      Ossn.MessageBox('likes/view?guid='+$post+'&type='+$type);
};

Ossn.PostUnlike = function(post){
     	Ossn.PostRequest({
					 url: Ossn.site_url+'action/post/unlike',
					 beforeSend: function(){
						$('#ossn-like-'+post).find('a').html('<img src="'+Ossn.site_url+'components/OssnComments/images/loading.gif" />');
					 },
                     params: '&post='+post,
					 callback:function(callback){
                       if(callback['done'] !== 0){ 
					  	 $('#ossn-like-'+post).find('a').html(callback['button']);
                         $('#ossn-like-'+post).find('a').attr('onclick', 'Ossn.PostLike('+post+');');
                       }
                        else {
                      	$('#ossn-like-'+post).find('a').html('Unlike'); 
                       }
					 },
					 });  
                       
};
Ossn.PostLike = function(post){
     	Ossn.PostRequest({
					 url: Ossn.site_url+'action/post/like',
					 beforeSend: function(){
					    $('#ossn-like-'+post).find('a').html('<img src="'+Ossn.site_url+'components/OssnComments/images/loading.gif" />');
					 },
                     params: '&post='+post,
					 callback:function(callback){
                       if(callback['done'] !== 0){
		                $('#ossn-like-'+post).find('a').html(callback['button']);
                        $('#ossn-like-'+post).find('a').attr('onClick', 'Ossn.PostUnlike('+post+');');
                       }
                       else {
                      	$('#ossn-like-'+post).find('a').html('Like'); 
                       }
					 },
					 }); 

};

Ossn.EntityUnlike = function(entity){
     	Ossn.PostRequest({
					 url: Ossn.site_url+'action/post/unlike',
					 beforeSend: function(){
						$('#ossn-like-'+entity).find('a').html('<img src="'+Ossn.site_url+'components/OssnComments/images/loading.gif" />');
					 },
                     params: '&entity='+entity,
					 callback:function(callback){
                       if(callback['done'] !== 0){ 
					  	 $('#ossn-like-'+entity).find('a').html(callback['button']);
                         $('#ossn-like-'+entity).find('a').attr('onclick', 'Ossn.EntityLike('+entity+');');
                       }
                        else {
                      	$('#ossn-like-'+entity).find('a').html('Unlike'); 
                       }
					 },
					 });  
                       
};
Ossn.EntityLike = function(entity){
     	Ossn.PostRequest({
					 url: Ossn.site_url+'action/post/like',
					 beforeSend: function(){
					    $('#ossn-like-'+entity).find('a').html('<img src="'+Ossn.site_url+'components/OssnComments/images/loading.gif" />');
					 },
                     params: '&entity='+entity,
					 callback:function(callback){
                       if(callback['done'] !== 0){
		                $('#ossn-like-'+entity).find('a').html(callback['button']);
                        $('#ossn-like-'+entity).find('a').attr('onClick', 'Ossn.EntityUnlike('+entity+');');
                       }
                       else {
                      	$('#ossn-like-'+post).find('a').html('Like'); 
                       }
					 },
					 }); 

};
Ossn.RegisterStartupFunction(function(){
   $(document).ready(function(){
	     $(document).delegate('.ossn-like-comment', 'click', function(e){
                e.preventDefault();
                var $item = $(this); 
                var $type = $.trim($item.text());
                var $url = $item.attr('href');
              	Ossn.PostRequest({
					 url: $url,
					 beforeSend: function(){
					    $item.html('<img src="'+Ossn.site_url+'components/OssnComments/images/loading.gif" />');
					 },
					 callback:function(callback){
                     if(callback == 1){
                           $total_guid = Ossn.UrlParams('annotation', $url);
                           $total = $('.ossn-total-likes-'+$total_guid).attr('data-likes');           
                        if($type == 'Like'){
                           $item.html('Unlike');
                           var unlike = $url.replace("like", "unlike");
                           $item.attr('href', unlike);
                           $total_likes = $total;
                           $total_likes++;
                           $('.ossn-total-likes-'+$total_guid).attr('data-likes', $total_likes);
                           $('.ossn-total-likes-'+$total_guid).html('<span class="dot-likes">.</span><div class="ossn-like-icon"></div>'+$total_likes);
                        }
                        if($type == 'Unlike'){
                           $item.html('Like');
                           var like = $url.replace("unlike", "like");
                           $item.attr('href', like);
                           if($total > 1){
                              $like_remove = $total;0
                              $like_remove--;
                              $('.ossn-total-likes-'+$total_guid).attr('data-likes', $like_remove); 
                              $('.ossn-total-likes-'+$total_guid).html('<span class="dot-likes">.</span><div class="ossn-like-icon"></div>'+$like_remove);
                           }  
                            if($total == 1){
                               $('.ossn-total-likes-'+$total_guid).attr('data-likes', 0); 
                               $('.ossn-total-likes-'+$total_guid).html('');

                            }
                        }
                      }
                        if(callback == 0){
                              if($type == 'Like'){
                                   $item.html('Like');
                                   Ossn.MessageBox('syserror/unknown'); 
                              }
                              if($type == 'Unlike'){
                                   $item.html('Unlike');
                                   Ossn.MessageBox('syserror/unknown'); 
 
                              } 
                        }  
                     },
					 });    
         }); 
	});
});