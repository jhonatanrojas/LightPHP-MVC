<?php

namespace lib;

use Facebook\Facebook;
use Abraham\TwitterOAuth\TwitterOAuth;

class SocialMediaPost
{
    private $facebook;
    private $twitter;

    public function __construct()
    {

        global $config;
        // Inicializa la API de Facebook
        $this->facebook = new Facebook([
            'app_id' => $config['APP_ID_FACEBOOK'],
            'app_secret' => $config['APP_SECRET_FACEBOOK'],
            'default_graph_version' => 'v16.0',
        ]);
        $apiKey         = $config['TWITTER_API_KEY'];
        $apiSecret      = $config['TWITTER_API_SECRET'];
        // Inicializa la API de Twitter
        $this->twitter = new TwitterOAuth(
            $apiKey,
            $apiSecret
        );
    }

    public function postToFacebook($text, $imageNames,$videoNames, $accessToken)
    {
        try {
            // Prepara los datos para la publicación
            $data = [
                'message' => $text,
            ];

            $images = $this->loadImagesFromServer($imageNames);
            $videos = $this->loadImagesFromServer($videoNames);
            $mediaArray = [];



            if (!empty($images)) {
                $uploadedPhotos = [];
                foreach ($images as $image) {
                    // Sube las imágenes a Facebook antes de publicarlas
                    $photoData = [
                        'source' => $this->facebook->fileToUpload($image, 'r'),
                        'published' => 'false', // Para que no se publiquen inmediatamente
                        'message' => $text,
                        


                    ];
                    $response = $this->facebook->post('/me/photos', $photoData, $accessToken);
                    $uploadedPhotos[] = $response->getGraphNode()->getField('id');
                }
                // Adjunta las imágenes subidas a la publicación
                if (!empty($uploadedPhotos)) {
                    $data['attached_media'] = json_encode(array_map(function ($photoId) {
                        return ['media_fbid' => $photoId];
                    }, $uploadedPhotos));
                }
            }
            if (!empty($mediaArray)) {
                $data['attached_media'] = json_encode($mediaArray);
            }

            //si hay videos los publica
            if (!empty($videos)) {
                $uploadedVideos = [];
                foreach ($videos as $video) {
                    // Sube las imágenes a Facebook antes de publicarlas
                    $videoData = [
                        'source' => $this->facebook->fileToUpload($video, 'r'),
                        'published' => 'false', // Para que no se publiquen inmediatamente
                        'message' => $text,
                    ];
                    $response = $this->facebook->post('/me/videos', $videoData, $accessToken);
                    $uploadedVideos[] = $response->getGraphNode()->getField('id');
                }
                // Adjunta las imágenes subidas a la publicación
                if (!empty($uploadedVideos)) {
                    $data['attached_media'] = json_encode(array_map(function ($videoId) {
                        return ['media_fbid' => $videoId];
                    }, $uploadedVideos));
                }
            }


            // Publica en la página de Facebook
            $response = $this->facebook->post('/me/feed',$data, $accessToken);
            return ['result' => true, 'message' => 'Publicado correctamente en Facebook', 'error' => ''];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Error al publicar en Facebook
     

            return ['error' => $e->getMessage(), 'message' => ' error al publicar en Facebook 001', 'result' => false];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Error con el SDK de Facebook
            return ['error' => $e->getMessage(), 'message' => ' error al publicar en Facebook 002', 'result' => false];
        }
    } 


    public function postToTwitter($text, $imageNames,$videoNames, $accessToken, $accessTokenSecret)
    {
        try {
            // Configura las credenciales de acceso para el usuario de Twitter
            $this->twitter->setOauthToken($accessToken, $accessTokenSecret);

            // Prepara los datos para la publicación
            $data = [
                'status' => $text,
            ];
            $mediaIds = [];
            $images = $this->loadImagesFromServer($imageNames);
            $videos = $this->loadImagesFromServer($videoNames);
            if (!empty($images)) {
                foreach ($images as $image) {
                    $uploadedMedia = $this->twitter->upload('media/upload', ['media' => $image]);
                    $mediaIds[] = $uploadedMedia->media_id_string;
                }
                $parameters['media_ids'] = implode(',', $mediaIds);
            }

            if (!empty($videos)) {
                $media = $this->twitter->upload('media/upload', [
                    'media' => $videos[0],
                    'media_type' => 'video/mp4',
                    'media_category' => 'tweet_video'
                ], true);
    
                if ($media->processing_info->state === 'succeeded') {
                    $data['media_ids'] = $media->media_id_string;
                } else {
                    // Manejar el error en la subida del video
                }
            }

            // Publica en Twitter
            $response = $this->twitter->post('statuses/update', $data);

            if ($this->twitter->getLastHttpCode() == 200) {
                return ['result' => true, 'message' => 'Tweet publicado correctamente',  $response, 'error' => ''];
            } else {



                return [
                    'error' => $response->errors[0]->message, 'message' => 'Error al publicar el tweet',
                    'code' => $response->errors[0]->code, 'result' => false
                ];
            }
        } catch (\Exception $e) {

            // Error con la API de Twitter, maneja el error aquí

            return ['error' => 'Error al publicar el tweet', 'message' => $e->getMessage(), 'result' => false];
        }
    }

    private function loadImagesFromServer($imageNames)
    {
        $images = [];
        $uploadDir = __DIR__ . '/../uploads/'; // Reemplaza esto con la ruta a tu directorio de imágenes

        foreach ($imageNames as $imageName) {
            $imagePath = $uploadDir . $imageName;
            if (file_exists($imagePath)) {
                $images[] = $imagePath;
            }
        }

        return $images;
    }

    public function  obtenerIdAlbunFacebook($accessToken)
    {
        try {
            $response = $this->facebook->get('/me/albums?fields=id,name', $accessToken);
            $graphEdge = $response->getGraphEdge();

            $timelineAlbumId = null;
            foreach ($graphEdge as $album) {
                if ($album['name'] === 'Timeline Photos') {
                    $timelineAlbumId = $album['id'];
                    break;
                }
            }

            if ($timelineAlbumId === null) {
                throw new \Exception('No se pudo encontrar el álbum "timeline".');
            }

            return $timelineAlbumId;
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Error al obtener el ID del álbum, maneja el error aquí
            return ['error' => $e->getMessage(), 'message' => ' error al obtener el ID del álbum', 'result' => false];
            // ...
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Error con el SDK de Facebook, maneja el error aquí
            return ['error' => $e->getMessage(), 'message' => ' error con el SDK de Facebook', 'result' => false];
            // ...
        }
    }

    public function postToInstagram($text, $imageNames, $accessToken, $instagramAccountId)
    {
        try {
            $data = [
                'caption' => $text,
                'access_token' => $accessToken,
                'image_url' => '', 
            ];

            $images = $this->loadImagesFromServer($imageNames);
            if (!empty($images)) {
                $data['image_url'] = $images[0]; // Si hay varias imágenes, puedes publicarlas en un carrusel utilizando el parámetro 'media_bundle'
            }

            // Publica en el feed de Instagram
            $response = $this->facebook->post("/$instagramAccountId/media", $data);

            return ['result' => true, 'message' => 'Publicado correctamente en Instagram', 'error' => ''];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Error al publicar en Instagram
           
            return ['error' =>$e->getRawResponse(), 'message' => ' error al publicar en Instagram 001', 'result' => false];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Error con el SDK de Facebook
            return ['error' => $e->getMessage(), 'message' => ' error al publicar en Instagram 002', 'result' => false];
        }
    }

    public function postToInstagramMultipleImages($text, $image_urls, $access_token)
{
    try {
        // Sube las imágenes a Facebook antes de publicarlas en Instagram
        $uploadedPhotos = [];
        foreach ($image_urls as $image_url) {
            $photoData = [
                'url' => $image_url,
            ];
            $response = $this->facebook->post('/me/photos', $photoData, $access_token);
            $uploadedPhotos[] = $response->getGraphNode()->getField('id');
        }

        // Prepara los datos para la publicación en Instagram
        $media_array = [];
        foreach ($uploadedPhotos as $photoId) {
            $media_array[] = ['media_fbid' => $photoId];
        }
        $data = [
            'caption' => $text,
            'media_bundle' => json_encode($media_array),
        ];

        // Publica en Instagram
        $response = $this->facebook->post('/me/media', $data, $access_token);

        if ($response->isError()) {
            return ['result' => false, 'message' => 'Error al publicar en Instagram', 'error' => $response->isError()];
        } else {
            return ['result' => true, 'message' => 'Publicado correctamente en Instagram', 'error' => ''];
        }
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        // Error al publicar en Instagram
        return ['error' => $e->getMessage(), 'message' => 'Error al publicar en Instagram', 'result' => false];
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        // Error al publicar en Instagram   
        return ['error' => $e->getMessage(), 'message' => 'Error al publicar en Instagram', 'result' => false];
    }
}


}
