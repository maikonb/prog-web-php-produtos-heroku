# Exemplo de aplicação PHP para a disciplina de Prog. Web

## Demonstração

[Acesse a demonstração aqui.](http://guarded-hollows-90344.herokuapp.com/)

## Descrição

Essa aplicação contém todos os recursos aprendidos até agora na disciplina integrados. A idéia aqui é demonstrar como organizar uma aplicação utilizando a orientação a objetos com acesso a banco de dados SQL. 

## Recursos

- Linguagens: PHP, HTML e SQL
- Banco de dados: MySQL
- Framework CSS: Bootstrap
- Frameworks Backend: nenhum
- Deploy: Heroku

```
heroku login
git add .
git commit -m "Adicionando projeto."
heroku create
heroku addons
git push heroku master
heroku addons:create cleardb:ignite
heroku config | grep CLEARDB_DATABASE_URL
heroku logs --tail
heroku open
git add *
git commit -m "alterando conexao com bd"
heroku run 'php /app/migration/criar-tabelas.php'
heroku run 'php /app/migration/criar-registros.php'
```
