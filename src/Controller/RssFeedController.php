<?php

namespace Watson\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class RssFeedController
{
    public function rssFeed(Application $app)
    {
        try {
            // Récupérer les 15 derniers liens ajoutés
            $links = $app['dao.link']->getLastLinks(15);

            // Générer le xml du flux RSS
            $rss = '<?xml version="1.0" encoding="UTF-8"?>';
            $rss .= '<rss version="2.0"><channel>';
            $rss .= '<title>Derniers liens ajoutés</title>';
            $rss .= '<link>' . $app['request_stack']->getCurrentRequest()->getSchemeAndHttpHost() . '</link>';
            $rss .= '<description>Les 15 derniers liens ajoutés</description>';

            foreach ($links as $link) {
                $rss .= '<item>';
                $rss .= '<title>' . htmlspecialchars($link->getTitle()) . '</title>';
                $rss .= '<link>' . htmlspecialchars($link->getUrl()) . '</link>';
                $rss .= '<description>' . htmlspecialchars($link->getDesc()) . '</description>';
                $rss .= '</item>';
            }

            $rss .= '</channel></rss>';

            // Retourner le flux RSS avec l'en-tête correct
            return new Response($rss, 200, ['Content-Type' => 'text/xml']);
        } catch (\Exception $e) {
            return new Response('DAO ERROR: ' . $e->getMessage(), 500);
        }
    }
}
