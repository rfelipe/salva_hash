Rodar projeto

    1.composer install
    2.Criar o banco de dados 
    3.Configurar o banco no o arquivo .env 
    na variavel DATABASE_URL 
    ex.: DATABASE_URL="mysql://user_do_banco:senha_do_banco@127.0.0.1:3306/nome_da_tabela_criada"
    4.php bin/console doctrine:migrations:migrate
   


--salvar dados:
php bin/console app:test `string` --requests=0

--consultar menor tentativas
php bin/console app:consult `numero`

Executar server:
symfony server:start