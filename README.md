TestApi
=======

A Symfony project created on November 27, 2016, 10:44 pm.



Clone project :
---------------

      git clone https://github.com/bradai/TESTAPI.git
      cd TestApi
      composer install or composer update

Step for install Project :
--------------------------

     php bin/console doctrine:database:create
     php bin/console doctrine:schema:create

      il faut cree des article fixtures en base


Url de test de Api  gestion article :
-----------------------------------------
Methode         url                   Description

GET             /api/articles         Liste des article
GET             /api/articles/{id}    retourne un article avec id
POST            /api/articles         Ajout d'un article
DELETE          /api/articles/{id}    Delete un article avec id