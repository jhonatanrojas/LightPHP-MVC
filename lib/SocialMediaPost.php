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

    public function postToFacebook($text, $imageNames, $accessToken)
    {
        try {
            // Prepara los datos para la publicación
            $data = [
                'message' => $text,
            ];

            $images = $this->loadImagesFromServer($imageNames);
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

            // Publica en la página de Facebook
            $response = $this->facebook->post('/me/feed',$data, $accessToken);
            return ['result' => true, 'message' => 'Publicado correctamente en Facebook', 'error' => ''];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // Error al publicar en Facebook
            echo $e->getRawResponse();

            return ['error' => $e->getMessage(), 'message' => ' error al publicar en Facebook 001', 'result' => false];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // Error con el SDK de Facebook
            return ['error' => $e->getMessage(), 'message' => ' error al publicar en Facebook 002', 'result' => false];
        }
    }


    public function postToTwitter($text, $imageNames, $accessToken, $accessTokenSecret)
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
            if (!empty($images)) {
                foreach ($images as $image) {
                    $uploadedMedia = $this->twitter->upload('media/upload', ['media' => $image]);
                    $mediaIds[] = $uploadedMedia->media_id_string;
                }
                $parameters['media_ids'] = implode(',', $mediaIds);
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
}
