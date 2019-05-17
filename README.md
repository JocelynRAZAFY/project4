# Private Chat Application with Symfony 4, FOSUserBundle, GOSWebSocketBundle and Vue.js

Cette application sert comme une didactic sur symfony 4.

Steps:  
    - composer install  
    - npm install  
    - yarn encore dev --watch  
    - php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
    
docker:
    - docker-compose up -d (pour demarrer les containers )
    - docker-compose down (pour arrêter les containers)
    