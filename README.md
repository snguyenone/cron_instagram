# cron_instagram
This module cron insgram with supporrt library http guzzlehttp

- Before you need download library http "guzzlehttp" with url :
 Ex: https://packagist.org/packages/guzzlehttp/guzzle

- After you need move Instagram to folder Your Project 

- Run Instagram:
    
    . You need a account instagram
    . Call function login Insgram
        Ex:  
         $login = new CurlLogin(USER_NAME] USER_PASS);
         $clientRequest = new Init($login);
         
    . Send a request "LIKE"
         $clientRequest->like("MEDIA_ID") // This is ID of a media post you need like
    
    . Send a request "FOLLOW"
       $clientRequest->like("OWNER_ID") // This is ID of a media post you need like    
    
    . Note: 
            
        - You has send more requests for jobs so you needs only call :

            $clientRequest = new Init($login);
            
        - You can send request load info OWNER_ID and MEDIA_ID with name hastag of instagram
     
         Ex: 
               $dataTag = $clientRequest->tagsResponse("[Array data tags name]")    
        
                /**
                 * @param array $dataTag
                 * @return object
                 */
                public function tagsResponse(array $dataTag = [])
                {
                    return $this->objTag->getMultiTags($dataTag);
                }
        