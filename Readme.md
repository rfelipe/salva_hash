Rodar projeto

    1.composer install
    2.Criar o banco de dados
    3.Configurar o banco no o arquivo .env
    4.php bin/console doctrine:migrations:migrate
   


salvar dados:
php bin/console app:test `string` --requests=0


Executar server:
symfony server:start