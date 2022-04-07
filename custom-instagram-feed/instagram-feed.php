<?php
add_shortcode('instagram','instagram_feed');
function instagram_feed($atts = array()){
   $args = shortcode_atts( array(
      'small' => 6,
      'medium' => 4,
      'large' => 4,
      'username' => '',
      'sid' => '', //52614606195%3A0j0Oo82b6m5fTM%3A12
      'layout' => 12,
   ), $atts );

   if (!empty($args['username'])&&!empty($args['sid'])) {
      $response = getIGProfile($args['username'], $args['sid']);
      if (isset($response->graphql)) {
         $images = $response->graphql->user->edge_owner_to_timeline_media->edges;
         $img_length = $args['layout'];
         if ($img_length>count($images)) {
            $img_length = count($images);
         }
         ob_start();?>
         <div class="row instagram-feed">
         <?php for($idx = 0; $idx < $img_length; $idx++) { ?>
            <div class="col small-<?= $args['small']; ?> medium-<?= $args['medium']; ?> large-<?= $args['large']; ?>">
               <div class="col-inner">
                  <div class="img has-hover mb-0 x md-x lg-x y md-y lg-y full-width">
                     <a class="feed-link" href="https://www.instagram.com/p/<?= $images[$idx]->node->shortcode ?>" target="_blank" rel="noopener noreferrer">
                        <div class="img-inner dark">
                           <img width="1020" height="1020"
                           src="<?= encodeimg($images[$idx]->node->thumbnail_src); ?>"
                           class="attachment-large size-large" alt="Instagram Feed Image" loading="lazy" sizes="(max-width: 1020px) 100vw, 1020px" />
                           <?php if(isset($images[$idx]->node->edge_sidecar_to_children)){ ?>
                           <svg aria-label="Carousel" class="multiplepost" color="#ffffff" fill="#ffffff" role="img" viewBox="0 0 48 48"
                              width="28" height="28">
                              <path
                                 d="M34.8 29.7V11c0-2.9-2.3-5.2-5.2-5.2H11c-2.9 0-5.2 2.3-5.2 5.2v18.7c0 2.9 2.3 5.2 5.2 5.2h18.7c2.8-.1 5.1-2.4 5.1-5.2zM39.2 15v16.1c0 4.5-3.7 8.2-8.2 8.2H14.9c-.6 0-.9.7-.5 1.1 1 1.1 2.4 1.8 4.1 1.8h13.4c5.7 0 10.3-4.6 10.3-10.3V18.5c0-1.6-.7-3.1-1.8-4.1-.5-.4-1.2 0-1.2.6z">
                              </path>
                           </svg>
                           <?php } ?>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
            <?php
         } ?>
         </div>
         <style>
            .row.instagram-feed .img{
               transition: .4s;
            }
            .row.instagram-feed .img:hover{
               filter: brightness(0.8);
            }
            .multiplepost{
               position: absolute;
               top: 2%;
               right: 2%;
            }
         </style>
         <?php
         $contents = ob_get_contents();
         ob_end_clean();
      }else{
         $contents = '<p>Visit our Instagram <a class="feed-link" href="https://www.instagram.com/'.$args['username'].'" target="_blank" rel="noopener noreferrer">@'.$args['username'].'</a></p>';
      }
   }else{
      $contents = '<p>username & sid dibutuhkan.</p>';
   }
   return $contents;
}

function encodeimg($url){
	$imageData = base64_encode(file_get_contents($url));
	$src = 'data: image/jpg;base64,'.$imageData;
	return $src;
}
function getIGProfile($username, $sessionid){
   $sid = 'sessionid='.$sessionid.';'; // Your Session ID (Google Crome Cookies)
   $headerArr = array("Cookie: $sid");
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, 'https://www.instagram.com/'.$username.'/channel/?__a=1');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
   $body = curl_exec($ch);
   curl_close($ch);
   $jsonData = json_decode($body);
   return $jsonData;
}