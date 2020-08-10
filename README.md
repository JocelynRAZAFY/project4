# Projet Symfony 4
- Email: rt1jocelyn@gmail.com
- linkedin: https://www.linkedin.com/in/jocelyn-razafimaharo-a4628098/
- Tel: +261 33 71 841 27
Cette application sert comme une didactic sur symfony 4.

Steps:  
    
    - composer install  
    
    - npm install  
    
    - yarn watch
    
    - php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
    
    - php bin/console rabbitmq:consumer test
    
Symfony lunch docker:

    - Install Docker
    
    - Install `docker-compose`
    
    - docker-compose up -d (pour demarrer les containers )
    
    - docker-compose down (pour arrêter les containers)
    
Symfony Local Web Server:

    - symfony server:start
    